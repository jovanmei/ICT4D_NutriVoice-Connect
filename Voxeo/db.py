import psycopg2

# Connect to the database
conn = psycopg2.connect(
    host="balarama.db.elephantsql.com",
    port=5432,
    dbname="xryelmsw",
    user="xryelmsw",
    password="CIoXXDLI4L21xbThDFCHIh4zLbAdJ4-E"
)

# Create the mushroom and oil tables
cur = conn.cursor()
cur.execute("""
    CREATE TABLE IF NOT EXISTS mushroom (
        mushroom_id SERIAL PRIMARY KEY,
        seller_name TEXT NOT NULL,
        seller_phone TEXT NOT NULL,
        stock INTEGER NOT NULL,
        unit_price NUMERIC(10,2) NOT NULL
    )
""")
cur.execute("""
    CREATE TABLE IF NOT EXISTS oil (
        oil_id SERIAL PRIMARY KEY,
        seller_name TEXT NOT NULL,
        seller_phone TEXT NOT NULL,
        stock INTEGER NOT NULL,
        unit_price NUMERIC(10,2) NOT NULL
    )
""")

# Insert values into the mushroom and oil tables
cur.execute("""
    INSERT INTO mushroom (seller_name, seller_phone, stock, unit_price)
    VALUES 
        ('North market', '+31626483123', 2000, 10.00),
        ('South market', '+31626483234', 2100, 8.50)
""")
cur.execute("""
    INSERT INTO oil (seller_name, seller_phone, stock, unit_price)
    VALUES 
        ('East market', '+31626483235', 2000, 13.00),
        ('West market', '+31626483345', 2700, 15.00)
""")

# Create the orders table
cur.execute("""
    CREATE TABLE IF NOT EXISTS orders (
        order_id SERIAL PRIMARY KEY,
        buyer_phone TEXT NOT NULL,
        purchase_type TEXT NOT NULL,
        seller_name TEXT NOT NULL,
        quantity INTEGER NOT NULL,
        unit_price NUMERIC(10,2) NOT NULL,
        total_price NUMERIC(10,2) NOT NULL
    )
""")

cur.execute("""
    INSERT INTO orders (buyer_phone, purchase_type, seller_name, quantity, unit_price, total_price)
    VALUES 
        ('123456789', 'mushroom', 'North market', 2, 10.00, 20.00)
""")

# Commit the changes and close the cursor and connection
conn.commit()
cur.close()
conn.close()
