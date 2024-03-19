INF 653 Midterm Project
Overview
This REST API is designed to serve as a comprehensive platform for managing and retrieving quotes, authors, and categories. It supports a wide range of operations, including fetching data, creating new entries, updating existing ones, and deleting records. The API is built with efficiency and ease of use in mind, providing clear and concise endpoints for interacting with the database. This project utilizes Postgres for its database needs and is hosted on Google Cloud, ensuring reliable access and performance.

API Endpoints
GET Requests
/quotes/: Returns all quotes.
/quotes/?id={quoteId}: Returns a specific quote by its ID.
/quotes/?author_id={authorId}: Returns all quotes from a specific author.
/quotes/?category_id={categoryId}: Returns all quotes in a specific category.
/quotes/?author_id={authorId}&category_id={categoryId}: Returns all quotes from a specific author that are in a specific category.
/authors/: Returns all authors with their IDs.
/authors/?id={authorId}: Returns a specific author by their ID.
/categories/: Returns all categories with their IDs.
/categories/?id={categoryId}: Returns a specific category by its ID.
If no records are found for the above routes, a { message: 'No Quotes Found' }, { message: 'author_id Not Found' }, or { message: 'category_id Not Found' } response is returned as appropriate.

POST Requests
/quotes/: Creates a new quote. Requires quote, author_id, and category_id.
/authors/: Creates a new author. Requires author.
/categories/: Creates a new category. Requires category.
If required parameters are missing, a { message: 'Missing Required Parameters' } response is returned. If an author_id or category_id does not exist, a corresponding { message: 'author_id Not Found' } or { message: 'category_id Not Found' } response is returned.

PUT Requests
/quotes/: Updates an existing quote. Requires id, quote, author_id, and category_id.
/authors/: Updates an existing author. Requires id and author.
/categories/: Updates an existing category. Requires id and category.
If no records are found to update or if required parameters (except id) are missing, appropriate { message: 'No Quotes Found' } or { message: 'Missing Required Parameters' } responses are returned.

DELETE Requests
/api/quotes/: Deletes a quote by its ID.
/api/authors/: Deletes an author by their ID.
/api/categories/: Deletes a category by its ID.
If no records are found to delete, a { message: 'No Quotes Found' } response is returned.

Additional Information
Database: Postgres
Hosting: Google Cloud

Author
Oakley Cardwell
