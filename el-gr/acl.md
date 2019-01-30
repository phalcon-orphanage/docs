---
layout: article
language: 'el-gr'
version: '4.0'
upgrade: '#acl'
category: 'acl'
---
# Access Control Lists Component

* * *

- [Λίστες ελέγχου πρόσβασης (ACL)](acl-overview)
- [Δημιουργώντας Λίστες Ελέγχου Πρόσβασης](acl-setup)
- [Adding Operations](acl-adding-operations)
- [Adding Subjects](acl-adding-subjects)
- [Καθορισμός ελέγχων πρόσβασης](acl-access-controls)
- [Αναζητώντας ένα ACL](acl-querying)
- [Πρόσβαση βασισμένη σε λειτουργίες](acl-function-based-access)
- [Objects as operation name and subject name](acl-objects)
- [Operations Inheritance](acl-operations-inheritance)
- [Σειρογραφία Λίστες ACL](acl-serialization)
- [Γεγονότα](acl-events)
- [Implementing your own adapters](acl-custom-adapters)

* * *

## Λίστες ελέγχου πρόσβασης (ACL)

Το [Phalcon \ Acl](api/Phalcon_Acl) παρέχει μια εύκολη και ελαφριά διαχείριση των ACL καθώς και τα δικαιώματα που τους συνοδεύουν. [Οι λίστες ελέγχου πρόσβασης](https://en.wikipedia.org/wiki/Access_control_list) (ACL) επιτρέπουν σε μια εφαρμογή να ελέγχει την πρόσβαση στις περιοχές της και τα αντικείμενα από τα αιτήματα.

Εν ολίγοις, οι ACL έχουν δύο αντικείμενα: το αντικείμενο που χρειάζεται πρόσβαση, και το αντικείμενο που χρειαζόμαστε την πρόσβαση. Στον κόσμο του προγραμματισμού, αυτές αναφέρονται συνήθωςι ως πράξεις και θέματα. Στον κόσμο του Phalcon, χρησιμοποιούμε την ορολογία [λειτουργία](api/Phalcon_Acl_Operation) και [θέμα](api/Phalcon_Acl_Subject).

> **Use Case**
> 
> Μια εφαρμογή λογιστικής χρειάζεται διαφορετικές ομάδες χρηστών να έχουν πρόσβαση σε διάφορες περιοχές της εφαρμογής.
> 
> **Operation** - Administrator Access - Accounting Department Access - Manager Access - Guest Access
> 
> **Subject** - Login page - Admin page - Invoices page - Reports page {:.alert .alert-info}

Όπως φαίνεται ανωτέρω, στην περίπτωση χρήσης, μια [λειτουργία](api/Phalcon_Acl_Operation) ορίζεται ως ποιός χρειάζεται για να αποκτήσει πρόσβαση σε ένα συγκεκριμένο [θέμα](api/Phalcon_Acl_Subject) δηλαδή, μια περιοχή από της εφαρμογής. Σαν [θέμα](api/Phalcon_Acl_Subject) ορίζουμε την περιοχή της εφαρμογής που πρέπει να προσβληθεί.

Χρησιμοποιώντας το στοιχείο [Phalcon\Acl](api/Phalcon_Acl), μπορούμε να συνδέσουμε αυτά τα δύο μαζί, και να ενισχύσουμε την ασφάλεια της εφαρμογής μας, επιτρέποντας μόνο συγκεκριμένες λειτουργίες να δεσμευθούν σε συγκεκριμένα θέματα.