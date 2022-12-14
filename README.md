# Préambule #

Ce repo est issue d'une formation sur la création d'un site e-commerce avec Symfony 5.
Formation disponible sur Udemy : <https://www.udemy.com/course/creer-un-site-e-commerce-avec-symfony-5/>.

Nous avons travaillé pour créer une application complète d'un site e-commerce :
    - Gestion des utilisateurs,
    - Les formulaires de contact, création de compte, connexion, etc...
    - Un backoffice avec EasyAdmin pour la gestion des produits, des commandes, des utilisateurs, etc...
    - Un tunnel d'achat
    - L'envoie de mail avec MailJet
    - Le paiement avec Stripe
    - Une base de données avec MySQL et Doctrine
    - Twig pour la gestion des templates

## v1 ##

La v1 est la version finale réalisée pendant la formation. Elle est disponible sur la branche `main` et accessible en ligne sur <https://laboutiquefrancaise.julienlaurent.com/>.
Pour des raisons de sécurité et de RGPD, j'ai décidé de bloquer les possiblité de créer un compte, d'ajouter/modifier une adresse et la modification du mot de passe. Ceci afin de ne pas avoir de données personnelles dans ma base de données.

L'application peut être utilisée uniquement avec l'identifiant suivant :
    - Email : julien@embauchez.moi
    - Password : Merci!

=> PS : il y a un petit message subliminal ;)

Veuillez noter aussi que Stripe est en mode test, donc les paiements ne sont pas réellement effectués. Pour faire des tests, vous pouvez utiliser la carte test :
    - Numéro : 4242 4242 4242 4242
    - Date d'expiration : 04/24
    - CVC : 242
    - Titulaire : n'importe quel texte

Merci,
Julien.