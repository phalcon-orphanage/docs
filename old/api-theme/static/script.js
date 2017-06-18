var ZepDoc = (function($){

    var ZepDoc = {};


    ZepDoc.drawLeftMenu = function(search){

        if(search){
            
            // TODO : improve search to perform better on large datasets

            search = search.toLowerCase();
            
            var fullData = {
                
                "allClasses"    : {},
                "allNamespaces" : {}
                
            };
            
            var buildDataRecur = function(localData,fullData){
                
                var subClasses    = [];
                var subNamespaces = [];
                
                for(var i = 0 ; i<localData.classes.length ; i++){
                    var subCs = ZephirApi.allClasses[localData.classes[i]];

                    if( subCs.shortname.toLowerCase().indexOf(search) >= 0 ){
                        fullData.allClasses[subCs.name] = subCs;
                        subClasses.push(subCs.name);
                    }
                }

                for(var i = 0 ; i<localData.namespaces.length ; i++){
                    var subNs = ZephirApi.allNamespaces[localData.namespaces[i]];

                    var children = buildDataRecur(subNs,fullData);
                                        
                    if( children.classes.length > 0 || children.namespaces.length > 0 || subNs.shortName.toLowerCase().indexOf(search) >= 0 ){
                        subNs = JSON.parse(JSON.stringify(subNs));
                        
                        subNs.classes    = children.classes;
                        subNs.namespaces = children.namespaces;
                        
                        fullData.allNamespaces[subNs.name] = subNs;
                        subNamespaces.push(subNs.name);
                        
                    }
                    
                }
                
                return {
                    
                    classes    : subClasses,
                    namespaces : subNamespaces
                    
                };
                
            };
            
            var fullData = {
                
                "allClasses"    : {},
                "allNamespaces" : {}
                
            };
            
            var builtTree = buildDataRecur(ZephirApi,fullData);
            
            fullData.classes    = builtTree.classes;
            fullData.namespaces = builtTree.namespaces;
        
            

        }else{
            var fullData = ZephirApi;
        }

        $("#menu-wrapper").empty();
        $("#menu-wrapper").append(ZepDoc.drawMenuNode(fullData,fullData,0));


        var odd=true;
        $("#menu-wrapper").find("li").each(function(){
            var curClass = odd ? "odd" : "even";
            odd = !odd;
            $(this).addClass(curClass);
            $(this).children("a").css({
                "padding-left": parseInt($(this).attr("menu-depth")) * 10
            });
        });


    };

    ZepDoc.drawMenuNode = function(localData,fullData,depth){

        var $node = $("<ul/>");
        $node.addClass("menu-node");
        $node.attr("menu-depth",depth);
        depth++;


        for(var i = 0 ; i<localData.namespaces.length ; i++){

            var curNs = fullData.allNamespaces[localData.namespaces[i]];
            var $nsItem = $("<li class='menu-ns'><a><span></span></a></li>");
            $nsItem.attr("menu-depth",depth);
            $nsItem.find("a").append(curNs.shortName);
            $nsItem.attr("data-ns-name",curNs.name);
            $nsItem.attr("title",curNs.name);

            $nsItem.append(ZepDoc.drawMenuNode(curNs,fullData,depth));
            $node.append($nsItem);

        }

        for(var i = 0 ; i<localData.classes.length ; i++){

            var curClass = fullData.allClasses[localData.classes[i]];
            var $cItem = $("<li class='menu-class'><a></a></li>");
            $cItem.find("a").html(curClass.shortname);
            $cItem.attr("title",curClass.name);
            $cItem.attr("menu-depth",depth);

            $cItem.find("a").attr("href", ZepCurrentPath  + "class/" + curClass.name.replace(/\\/g,"/") + ".html");
            $cItem.addClass( "type-" + curClass.type);
            $cItem.attr("data-class-name",curClass.name);




            $node.append($cItem);

        }

        return $node;


    };




    $(function(){

        ZepDoc.drawLeftMenu();
        
        var searchTimer = null;
        
        $("#body-left .search-box").bind("input",function(){
            
            var self = this;
            
            if(null !== searchTimer)
                clearTimeout(searchTimer);
            
            
            
            searchTimer = setTimeout(function(){
                
                var search = $(self).val().trim();
                if(search.length > 1)
                    ZepDoc.drawLeftMenu( search );
                else
                    ZepDoc.drawLeftMenu( );
                    
            },500);
            
        });

        $(".method-details .btn.view-source").each(function(){

            $(this).click(function(){
                $(this).closest(".method-details").find(".method-source").toggleClass("hide");
                if($(this).closest(".method-details").find(".method-source").hasClass("hide")){
                    $(this).removeClass("active");
                }else{
                    $(this).addClass("active");
                }
            });

        });

        $(".code-inside code").each(function(){
            $(this).addClass("php-source-file prettyprint linenums");
        });

        prettyPrint();

    });

    return ZepDoc;
})(jQuery);
