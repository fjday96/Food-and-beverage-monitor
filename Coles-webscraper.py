from selenium import webdriver
from urllib.request import urlopen as uReq
from bs4 import BeautifulSoup


for numb in ('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'):
	url = ('https://shop.coles.com.au/a/a-national/everything/browse/drinks/soft-drinks-3314551?pageNumber=' + numb)
	browser = webdriver.PhantomJS()
	browser.get(url)
	_html = browser.page_source

	brands = BeautifulSoup(_html).findAll("span",{"class":"product-brand"})

	brand = brands[0]

	product_names = BeautifulSoup(_html).findAll("span",{"class":"product-name"})

	product_name = product_names[0]

	prices = BeautifulSoup(_html).findAll("strong",{"class":"product-price"})

	price = prices[0]


	filename = "Coles-Beverage-Extraction-brand.csv"
	f = open(filename, "wb")
	header1 = "Brand \n"
	f.write(header1)

	for brand in brands:
		brand = brand.text
		print("Brand: " + brand)
		f.write(brand + "\n")

	f.close()

	filename = "Coles-Beverage-Extraction-product.csv"
	f = open(filename, "w")
	header2 = "Product \n"
	f.write(header2)

	for product_name in product_names:
		product_name = product_name.text
		print("Product: " + product_name)
		f.write(product_name + "\n")

	f.close()

	filename = "Coles-Beverage-Extraction-price.csv"
	f = open(filename, "w")
	header3 = "Price \n"
	f.write(header3)


	for price in prices:
		price = price.text
		print("Price: " + price)
		f.write(price + "\n")
	
	f.close()