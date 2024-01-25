# ask-nicely

## How to run
- Clone the repository
- Navigate into the project directory
- Simply run `docker compose up -d`

#### Notes:
- I experienced an issue where the `build` for `vue` fails with "/app/dist not found" when triggered through `docker compose` and `docker build`, but it works when using `npm run build`
  - after running `npm run build`, both `docker` commands start to work