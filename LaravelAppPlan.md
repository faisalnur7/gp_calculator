# Laravel Application Plan for Jewellery Document Management

## 1. Project Purpose

- Build a Laravel app to store jewellery purchase/sales documents.
- Use the Excel sheet as the initial dataset and model sample.
- Allow storing documents by shop profile, jewellery profile, date, images, and attachments.

## 2. Excel Data Analysis

Sheet: `Total`

Columns:
- Date
- Store
- Item name
- Vori
- Ana
- Roti
- Point
- Total Grams
- Total Vori
- Total Ana
- Total Roti
- Total Points
- Present Price (Per Gram)
- Sub Total

Observations:
- The spreadsheet records jewellery entries per shop and item.
- The shop is identified by `Store`.
- The jewellery item or description is in `Item name`.
- Weight is recorded in traditional units: Vori, Ana, Roti, Point.
- There is a calculated `Total Grams` and a monetary `Sub Total`.
- Some date rows currently contain Excel serial values (e.g. `43046`) and some string dates.

## 3. Domain Model

Entities:

- `Shop`
  - name
  - profile or description
  - address/contact details
  - category/type

- `JewelleryItem` (or `JewelleryProfile`)
  - name
  - category (necklace, ring, earring, chain, etc.)
  - description
  - default purity or weight unit preferences

- `Document`
  - shop_id
  - jewellery_item_id
  - document_date
  - reference_number
  - vori
  - ana
  - roti
  - point
  - total_grams
  - unit_price_per_gram
  - subtotal
  - notes
  - status

- `DocumentPhoto`
  - document_id
  - filename/path
  - caption

- `DocumentAttachment` (optional)
  - document_id
  - filename/path
  - type (invoice, certificate, photo)

Relationships:
- `Shop` hasMany `Document`
- `JewelleryItem` hasMany `Document`
- `Document` belongsTo `Shop`
- `Document` belongsTo `JewelleryItem`
- `Document` hasMany `DocumentPhoto`
- `Document` hasMany `DocumentAttachment`

## 4. Database Schema (Proposed)

Tables:

- `shops`
  - id
  - name
  - code
  - profile
  - address
  - phone
  - email
  - created_at, updated_at

- `jewellery_items`
  - id
  - name
  - category
  - description
  - created_at, updated_at

- `documents`
  - id
  - shop_id
  - jewellery_item_id
  - document_date
  - reference_number
  - vori
  - ana
  - roti
  - point
  - total_grams
  - unit_price_per_gram
  - subtotal
  - notes
  - created_at, updated_at

- `document_photos`
  - id
  - document_id
  - path
  - caption
  - created_at, updated_at

- `document_attachments`
  - id
  - document_id
  - path
  - type
  - created_at, updated_at

## 5. UI and Features

Core workflows:

- Shop management
  - add/edit/delete shops
  - view shop profile and documents

- Jewellery profile management
  - add/edit jewellery types
  - categorize jewellery items

- Document management
  - add/edit/delete documents
  - upload jewellery images and attachments
  - store document date, shop, jewellery item, weights, price, and subtotal
  - auto-calculate total grams if needed

- Search & filter
  - filter documents by shop, jewellery item, date range
  - search by reference, item name, or comments

- Excel import utility
  - import the existing Excel data into documents
  - normalize dates and map shops/items automatically

- Reporting / list view
  - document list with totals, weights, price, and shop summary
  - export or print as needed

## 6. Implementation Plan

Step 1: Bootstrap Laravel project
- Install Laravel via Composer.
- Configure `.env` for database.
- Set up Laravel authentication optionally.

Step 2: Create models and migrations
- `Shop`, `JewelleryItem`, `Document`, `DocumentPhoto`, `DocumentAttachment`
- Add foreign keys and indexes.

Step 3: Build CRUD controllers and routes
- Resource controllers for shops, jewellery items, documents.
- Nested routes for document images/attachments.

Step 4: Build front-end screens
- Use Blade + Bootstrap or Tailwind.
- Create dashboard and data listing pages.
- Add document form with upload fields.

Step 5: Excel import feature
- Add command or import page.
- Normalize Excel date values and string dates.
- Insert shops/items if missing.

Step 6: File storage
- Configure `storage/app/public` and symlink `public/storage`.
- Store images and attachments with secure paths.

Step 7: Testing
- Add feature tests for import, CRUD, and upload.
- Verify relationships and search filters.

## 7. Notes and Recommendations

- Use a single `documents` table as the central record for each jewellery transaction.
- Keep photos and attachments separate for flexibility.
- Normalize `shop` and `item` names to avoid duplicates during import.
- Convert all dates to a single format before saving.
- Use `total_grams` as the main numeric field for quantity-based reports.

## 8. Next Deliverable

- Create the Laravel project scaffold.
- Build the database model and migrations.
- Implement the document CRUD and import workflow.
- Import the provided Excel dataset and verify in the application.
