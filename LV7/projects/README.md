# Installation

## 1. In _backend_ folder create _config.env_ file

You should replace <user_name> and <db_password> with your Atlas credentials.

Your atals database should be named **webDB** and it should contain **projects** collection.

```
ATLAS_URI="mongodb+srv://<user_name>:<db_password>@cluster0.vwa4dco.mongodb.net/?retryWrites=true&w=majority&appName=Cluster0"
PORT=5050
```

## 2. Enter _backend_ folder and start backend server

```
npm install
node --env-file=config.env app
```

## 3. Install dependecies and run dev server

```
npm install
npm run dev
```
