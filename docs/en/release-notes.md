## 2017-02-20 - v.3.0.4
- Fixed Isnull check is not correct when the model field defaults to an empty string. [#12507](https://github.com/phalcon/cphalcon/issues/12507)
- Fixed `Phalcon\Forms\Element::label` to accept 0 as label instead of validating it as empty. [#12148](https://github.com/phalcon/cphalcon/issues/12148)
- Fixed `Phalcon\Crypt::getAvailableCiphers`, `Phalcon\Crypt::decrypt`, `Phalcon\Crypt::encrypt` by getting missed aliases for ciphers [#12539](https://github.com/phalcon/cphalcon/pull/12539)
- Fixed `Phalcon\Mvc\Model` by adding missed `use` statement for `ResultsetInterface` [#12574](https://github.com/phalcon/cphalcon/pull/12574)
- Fixed adding role after setting default action [#12573](https://github.com/phalcon/cphalcon/issues/12573)
- Fixed except option in `Phalcon\Validation\Validator\Uniquenss` to allow using except fields other than unique fields
- Cleaned `Phalcon\Translate\Adapter\Gettext::query` and removed ability to pass custom domain [#12598](https://github.com/phalcon/cphalcon/issues/12598), [#12606](https://github.com/phalcon/cphalcon/pull/12606)
- Fixed `Phalcon\Validation\Message\Group::offsetUnset` to correct unsetting a message by index [#12455](https://github.com/phalcon/cphalcon/issues/12455)
- Fix using `Phalcon\Acl\Role` and `Phalcon\Acl\Resource` as parameters for `Phalcon\Acl\Adapter\Memory::isAllowed`
