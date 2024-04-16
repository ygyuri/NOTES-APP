

# API Routes

## Get the Authenticated User
- **Method:** GET
- **URI:** /api/user
- **Description:** Endpoint to retrieve the authenticated user.
- **Middleware:** auth:sanctum
- **Controller Method:** Closure

## Create a New Note
- **Method:** POST
- **URI:** /api/notes
- **Description:** Endpoint to create a new note.
- **Middleware:** None (assuming authentication is handled globally)
- **Controller Method:** NoteController@store

## Get All Notes
- **Method:** GET
- **URI:** /api/notes
- **Description:** Endpoint to retrieve all notes.
- **Middleware:** None (assuming authentication is handled globally)
- **Controller Method:** NoteController@index

## Get a Single Note by ID
- **Method:** GET
- **URI:** /api/notes/{note}
- **Description:** Endpoint to retrieve a single note by ID.
- **Middleware:** None (assuming authentication is handled globally)
- **Controller Method:** NoteController@show

## Update a Note by ID
- **Method:** PUT
- **URI:** /api/notes/{note}
- **Description:** Endpoint to update a note by ID.
- **Middleware:** None (assuming authentication is handled globally)
- **Controller Method:** NoteController@update

## Delete a Note by ID
- **Method:** DELETE
- **URI:** /api/notes/{note}
- **Description:** Endpoint to delete a note by ID.
- **Middleware:** None (assuming authentication is handled globally)
- **Controller Method:** NoteController@destroy

# User Authentication API

This API provides endpoints for user registration and authentication.

### Routes

#### Register User
- **Endpoint:** `POST /api/register`
- **Description:** Registers a new user.

##### Request Body
- `name`: User's name
- `email`: User's email address
- `password`: User's password

##### Response
- `user`: Newly registered user

#### Login User
- **Endpoint:** `POST /api/login`
- **Description:** Logs in an existing user.

##### Request Body
- `email`: User's email address
- `password`: User's password

##### Response
- `token`: Authentication token for the logged-in user
