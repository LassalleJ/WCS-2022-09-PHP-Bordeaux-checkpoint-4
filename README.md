# WCS - Session 09/2022 - Checkpoint 4

## Presentation

This project is the final checkpoint of the Wild Code School bootcamp. 

The context - Each student had 2 days to build a wep app of its choice.

About the project itself : it is a platform to help players of the game World of Warcraft to form groups, 
based on their preference of playing the game. The aim is to form durable groups based on several parameters relevant in the game.

You will find in the directory Ressources some wireframes I made for this project, and a schema of the database.
### Install

1. Clone this project
2. Run `composer install`
3. Run `yarn install`
4. Run `yarn encore dev` to build assets
5. Create a .env.local file with your DB credentials.
6. Run `symfony console doctrine:database:create`
7. Run `symfony console doctrine:migrations:migrate`
8. Run `symfony console doctrine:fixtures:load`

### Working

1. Run `symfony server:start` to launch your local php web server
2. Run `yarn run dev --watch` to launch your local server for assets (or `yarn dev-server` do the same with Hot Module Reload activated)



## Built With

* [Symfony](https://github.com/symfony/symfony)

