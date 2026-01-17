# AI Usage

## Claude.com

I began with this prompt then dove into different details as they came up.

```
I would like to build a simple admin panel app using Laravel 12, PHP8.5 and Laravel Filament 5. As of today, January 16 2026, these are the most recent stable versions. Additionally I would like to include the following composer packages:

Spatie Laravel Query Builder (laravel-query-builder)
Laravel Pint
This will be a typical Sail application that I run in Docker but we will use a Postgres container instead of Mysql. We will center this admin panel around the products table. In our migration file we will have a products table, categories table and brands table. We will also make corresponding Eloquent models for all three. Here are the fields required for the migration:

products:

  ● id - PK
  ● title - varchar
  ● description - short text
  ● category_id - int FK points to categories
  ● brand_id - int FK points to brands
  ● price - int (cents)
  ● stock - int
  ● sku - varchar (format will be generic like SKU-00001, etc.)
  ● weight - float

categories:

  ● id - PK
  ● category - varchar

brands:

  ● id - PK
  ● brand - varchar

We will also have a seeder which will create 100 products. 
For the categories we will have five: hammers, wrenches, screws, drills, nails. 
For the brands we will also have five: Acme, Brown, Charlie, Delta, Edman. 
Let's distribute everything evenly so 20 products for each category but 
also 20 products for each brand. We can use Faker or you can simply hard code 
hardware lingo into the fields.

Let's also make a CRUD controller called HardwareController. I will flesh this out later.

I will create a Git repository for this. We should include a README.md file which will 
contain initial git clone instructions, which I will modify later, as well as basic Sail 
and Filament connection instructions. I will add more details later. Let me know if you 
have any questions before proceeding.
```

### Notes
 
- I later learned I didn't need to create a controller at all, so I deleted `HardwareController`
- Most of my questions centered around proper usage of Filament.
- I have an online `Claude` account, but I think also buying `Claude Code` and running it locally might have been quicker.
- Learning how to use Filament feels similar to an older Laravel admin panel called `Nova`.


