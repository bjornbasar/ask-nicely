# ask-nicely

## How to run
### Pre-requisites
- Docker
- Git
### Steps
- Clone the repository
```sh
git clone git@github.com:ian0583/ask-nicely.git
```
- Navigate into the project directory
```sh
cd ask-nicely
```
- Simply run `docker compose up -d`
```sh
docker compose up -d
```
- Go to `localhost:8081` from any browser
- Listing page should have an empty table
- Click on "Upload" to display the Upload page
- Select the CSV provided from the test
- Click on "Upload CSV"
- Successful upload will redirect back to the Listing; otherwise, an alert will be displayed
- Uploaded data should be displayed in the table, along with the average salary above the table
- Clicking on any records will open the Edit page
- User can modify the email address of the employee only

#### Notes:
- I experienced an issue where the `build` for `vue` fails with "/app/dist not found" when triggered through `docker compose` and `docker build`, but it works when using `npm run build`
  - after running `npm run build`, both `docker` commands start to work
