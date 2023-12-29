# Fabimage
![Fabimage-accueil](https://github.com/Nicolas-Montard/Fabimage/assets/58862995/6aae065b-fddf-4c54-b4ed-284acb23fc15)

Fabimage est un site répondant à la demande d'une coach en image souhaitant pouvoir présenter ses offres et vendre ses livres, tout en le rendant accessible en plusieurs langues (Français, Espagnol, Estonien).

Site accessible <a href="https://www.fabimage.coach/fr/" target="_blank">ici</a>

<strong>Langage :</strong> PHP<br>
<strong>Framework :</strong> Symfony<br>
<strong>Librairie Front :</strong> Bootstrap, Twig<br>
<strong>BDD :</strong> MySQL<br>

## Livres
![fabilmage-livre](https://github.com/Nicolas-Montard/Fabimage/assets/58862995/16bfbae7-8992-4645-9759-365403bac990)
La vente de livres se fait en utilisant l'api stripe. La sécurité est assurée en rendant les livres innaccessibles en public, avec comme seule possibilité pour télécharger le livre de se rendre sur une page envoyée par mail après l'achat et validée par un token.

## Responsif
Le site est pleinement responsif avec tous ses pages adaptés aux différents formats:
![fabimage-responsive](https://github.com/Nicolas-Montard/Fabimage/assets/58862995/a042a715-7c82-474d-9a72-637bc309cd91)

## Administration
### Connexion
L'administrateur peut se connecter et changer son mot de passe en se rendant sur la page login:
![fabimage-login](https://github.com/Nicolas-Montard/Fabimage/assets/58862995/1124d9df-6800-4bfd-885a-77415e578cfd)
Toutes les pages d'administration sont sécurisés pour qu'un utilisateur soit automatiquement redirigé vers la page d'accueil s'il n'est pas connecté.
### Gestion de contenu
Toutes les prestations et livres peuvent être administrés selon la méthode BREAD:
![fabimage-bread](https://github.com/Nicolas-Montard/Fabimage/assets/58862995/a913512f-260a-4c08-a146-a069db333007)
CKeditor a également été inclus à de nombreux champs de texte pour permettre une plus grande personnalisation.

