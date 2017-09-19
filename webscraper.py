from urllib.request import urlopen as uReq
from bs4 import BeautifulSoup as soup

my_url = 'http://www.raraavisclothing.com/products'

#opening up connection, grabbing the page
uClient = uReq(my_url)
page_html = uClient.read()
uClient.close()

#html parsing
page_soup = soup(page_html, "html.parser")

#grabs each product
products = page_soup.findAll("li",{"product"})

product = products[0]

#extracts the information to an excel spreadsheet
filename = "Rara-Avis_products.csv"
f = open(filename, "w")

headers = "Product, Price\n"

f.write(headers)

#loop of each product
for product in products:
	
	product_name = product.a.b.text
	price = product.a.i.text

	print("Product: " + product_name)
	print("Price: " + price)

	f.write(product_name + "," + price + "\n")

f.close()