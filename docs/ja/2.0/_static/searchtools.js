/*
 * searchtools.js_t
 * ~~~~~~~~~~~~~~~~
 *
 * Sphinx JavaScript utilties for the full-text search.
 *
 * :copyright: Copyright 2007-2011 by the Sphinx team, see AUTHORS.
 * :license: BSD, see LICENSE for details.
 *
 */

/**
 * helper function to return a node containing the
 * search summary for a given text. keywords is a list
 * of stemmed words, hlwords is the list of normal, unstemmed
 * words. the first one is used to find the occurance, the
 * latter for highlighting it.
 */

jQuery.makeSearchSummary = function(text, keywords, hlwords) {
  var textLower = text.toLowerCase();
  var start = 0;
  $.each(keywords, function() {
    var i = textLower.indexOf(this.toLowerCase());
    if (i > -1)
      start = i;
  });
  start = Math.max(start - 120, 0);
  var excerpt = ((start > 0) ? '...' : '') +
  $.trim(text.substr(start, 240)) +
  ((start + 240 - text.length) ? '...' : '');
  var rv = $('<div class="context"></div>').text(excerpt);
  $.each(hlwords, function() {
    rv = rv.highlightText(this, 'highlighted');
  });
  return rv;
}


/**
 * Dummy stemmer for languages without stemming rules.
 */
var Stemmer = function() {
  this.stemWord = function(w) {
    return w;
  }
}


/**
 * Search Module
 */
var Search = {

  _index : null,
  _queued_query : null,
  _pulse_status : -1,

  init : function() {
      var params = $.getQueryParameters();
      if (params.q) {
          var query = params.q[0];
          $('input[name="q"]')[0].value = query;
          this.performSearch(query);
      }
  },

  loadIndex : function(url) {
    $.ajax({type: "GET", url: url, data: null,
            dataType: "script", cache: true,
            complete: function(jqxhr, textstatus) {
              if (textstatus != "success") {
                document.getElementById("searchindexloader").src = url;
              }
            }});
  },

  setIndex : function(index) {
    var q;
    this._index = index;
    if ((q = this._queued_query) !== null) {
      this._queued_query = null;
      Search.query(q);
    }
  },

  hasIndex : function() {
      return this._index !== null;
  },

  deferQuery : function(query) {
      this._queued_query = query;
  },

  stopPulse : function() {
      this._pulse_status = 0;
  },

  startPulse : function() {
    if (this._pulse_status >= 0)
        return;
    function pulse() {
      Search._pulse_status = (Search._pulse_status + 1) % 4;
      var dotString = '';
      for (var i = 0; i < Search._pulse_status; i++)
        dotString += '.';
      Search.dots.text(dotString);
      if (Search._pulse_status > -1)
        window.setTimeout(pulse, 500);
    };
    pulse();
  },

  /**
   * perform a search for something
   */
  performSearch : function(query) {
    // create the required interface elements
    this.out = $('#search-results');
    this.title = $('<h2>' + _('Searching') + '</h2>').appendTo(this.out);
    this.dots = $('<span></span>').appendTo(this.title);
    this.status = $('<p style="display: none"></p>').appendTo(this.out);
    this.output = $('<ul class="search"/>').appendTo(this.out);

    $('#search-progress').text(_('Preparing search...'));
    this.startPulse();

    // index already loaded, the browser was quick!
    if (this.hasIndex())
      this.query(query);
    else
      this.deferQuery(query);
  },

  query : function(query) {
    var stopwords = [];

    // Stem the searchterms and add them to the correct list
    var stemmer = new Stemmer();
    var searchterms = [];
    var excluded = [];
    var hlterms = [];
    var tmp = query.split(/\s+/);
    var objectterms = [];
    for (var i = 0; i < tmp.length; i++) {
      if (tmp[i] != "") {
          objectterms.push(tmp[i].toLowerCase());
      }

      if ($u.indexOf(stopwords, tmp[i]) != -1 || tmp[i].match(/^\d+$/) ||
          tmp[i] == "") {
        // skip this "word"
        continue;
      }
      // stem the word
      var word = stemmer.stemWord(tmp[i]).toLowerCase();
      // select the correct list
      if (word[0] == '-') {
        var toAppend = excluded;
        word = word.substr(1);
      }
      else {
        var toAppend = searchterms;
        hlterms.push(tmp[i].toLowerCase());
      }
      // only add if not already in the list
      if (!$.contains(toAppend, word))
        toAppend.push(word);
    };
    var highlightstring = '?highlight=' + $.urlencode(hlterms.join(" "));

    // console.debug('SEARCH: searching for:');
    // console.info('required: ', searchterms);
    // console.info('excluded: ', excluded);

    // prepare search
    var filenames = this._index.filenames;
    var titles = this._index.titles;
    var terms = this._index.terms;
    var fileMap = {};
    var files = null;
    // different result priorities
    var importantResults = [];
    var objectResults = [];
    var regularResults = [];
    var unimportantResults = [];
    $('#search-progress').empty();

    // lookup as object
    for (var i = 0; i < objectterms.length; i++) {
      var others = [].concat(objectterms.slice(0,i),
                             objectterms.slice(i+1, objectterms.length))
      var results = this.performObjectSearch(objectterms[i], others);
      // Assume first word is most likely to be the object,
      // other words more likely to be in description.
      // Therefore put matches for earlier words first.
      // (Results are eventually used in reverse order).
      objectResults = results[0].concat(objectResults);
      importantResults = results[1].concat(importantResults);
      unimportantResults = results[2].concat(unimportantResults);
    }

    // perform the search on the required terms
    for (var i = 0; i < searchterms.length; i++) {
      var word = searchterms[i];
      // no match but word was a required one
      if ((files = terms[word]) == null)
        break;
      if (files.length == undefined) {
        files = [files];
      }
      // create the mapping
      for (var j = 0; j < files.length; j++) {
        var file = files[j];
        if (file in fileMap)
          fileMap[file].push(word);
        else
          fileMap[file] = [word];
      }
    }

    // now check if the files don't contain excluded terms
    for (var file in fileMap) {
      var valid = true;

      // check if all requirements are matched
      if (fileMap[file].length != searchterms.length)
        continue;

      // ensure that none of the excluded terms is in the
      // search result.
      for (var i = 0; i < excluded.length; i++) {
        if (terms[excluded[i]] == file ||
            $.contains(terms[excluded[i]] || [], file)) {
          valid = false;
          break;
        }
      }

      // if we have still a valid result we can add it
      // to the result list
      if (valid)
        regularResults.push([filenames[file], titles[file], '', null]);
    }

    // delete unused variables in order to not waste
    // memory until list is retrieved completely
    delete filenames, titles, terms;

    // now sort the regular results descending by title
    regularResults.sort(function(a, b) {
      var left = a[1].toLowerCase();
      var right = b[1].toLowerCase();
      return (left > right) ? -1 : ((left < right) ? 1 : 0);
    });

    // combine all results
    var results = unimportantResults.concat(regularResults)
      .concat(objectResults).concat(importantResults);

    // print the results
    var resultCount = results.length;
    function displayNextItem() {
      // results left, load the summary and display it
      if (results.length) {
        var item = results.pop();
        var listItem = $('<li style="display:none"></li>');
        if (DOCUMENTATION_OPTIONS.FILE_SUFFIX == '') {
          // dirhtml builder
          var dirname = item[0] + '/';
          if (dirname.match(/\/index\/$/)) {
            dirname = dirname.substring(0, dirname.length-6);
          } else if (dirname == 'index/') {
            dirname = '';
          }
          listItem.append($('<a/>').attr('href',
            DOCUMENTATION_OPTIONS.URL_ROOT + dirname +
            highlightstring + item[2]).html(item[1]));
        } else {
          // normal html builders
          listItem.append($('<a/>').attr('href',
            item[0] + DOCUMENTATION_OPTIONS.FILE_SUFFIX +
            highlightstring + item[2]).html(item[1]));
        }
        if (item[3]) {
          listItem.append($('<span> (' + item[3] + ')</span>'));
          Search.output.append(listItem);
          listItem.slideDown(5, function() {
            displayNextItem();
          });
        } else if (DOCUMENTATION_OPTIONS.HAS_SOURCE) {
          $.ajax({url: DOCUMENTATION_OPTIONS.URL_ROOT + '_sources/' + item[0] + '.txt',
                  dataType: "text",
                  complete: function(jqxhr, textstatus) {
                    var data = jqxhr.responseText;
                    if (data !== '') {
                      listItem.append($.makeSearchSummary(data, searchterms, hlterms));
                    }
                    Search.output.append(listItem);
                    listItem.slideDown(5, function() {
                      displayNextItem();
                    });
                  }});
        } else {
          // no source available, just display title
          Search.output.append(listItem);
          listItem.slideDown(5, function() {
            displayNextItem();
          });
        }
      }
      // search finished, update title and status message
      else {
        Search.stopPulse();
        Search.title.text(_('Search Results'));
        if (!resultCount)
          Search.status.text(_('Your search did not match any documents. Please make sure that all words are spelled correctly and that you\'ve selected enough categories.'));
        else
            Search.status.text(_('Search finished, found %s page(s) matching the search query.').replace('%s', resultCount));
        Search.status.fadeIn(500);
      }
    }
    displayNextItem();
  },

  performObjectSearch : function(object, otherterms) {
    var filenames = this._index.filenames;
    var objects = this._index.objects;
    var objnames = this._index.objnames;
    var titles = this._index.titles;

    var importantResults = [];
    var objectResults = [];
    var unimportantResults = [];

    for (var prefix in objects) {
      for (var name in objects[prefix]) {
        var fullname = (prefix ? prefix + '.' : '') + name;
        if (fullname.toLowerCase().indexOf(object) > -1) {
          var match = objects[prefix][name];
          var objname = objnames[match[1]][2];
          var title = titles[match[0]];
          // If more than one term searched for, we require other words to be
          // found in the name/title/description
          if (otherterms.length > 0) {
            var haystack = (prefix + ' ' + name + ' ' +
                            objname + ' ' + title).toLowerCase();
            var allfound = true;
            for (var i = 0; i < otherterms.length; i++) {
              if (haystack.indexOf(otherterms[i]) == -1) {
                allfound = false;
                break;
              }
            }
            if (!allfound) {
              continue;
            }
          }
          var descr = objname + _(', in ') + title;
          anchor = match[3];
          if (anchor == '')
            anchor = fullname;
          else if (anchor == '-')
            anchor = objnames[match[1]][1] + '-' + fullname;
          result = [filenames[match[0]], fullname, '#'+anchor, descr];
          switch (match[2]) {
          case 1: objectResults.push(result); break;
          case 0: importantResults.push(result); break;
          case 2: unimportantResults.push(result); break;
          }
        }
      }
    }

    // sort results descending
    objectResults.sort(function(a, b) {
      return (a[1] > b[1]) ? -1 : ((a[1] < b[1]) ? 1 : 0);
    });

    importantResults.sort(function(a, b) {
      return (a[1] > b[1]) ? -1 : ((a[1] < b[1]) ? 1 : 0);
    });

    unimportantResults.sort(function(a, b) {
      return (a[1] > b[1]) ? -1 : ((a[1] < b[1]) ? 1 : 0);
    });

    return [importantResults, objectResults, unimportantResults]
  }
}

$(document).ready(function() {
  Search.init();
});