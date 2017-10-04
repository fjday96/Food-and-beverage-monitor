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

	names = BeautifulSoup(_html).findAll("span",{"class":"product-name"})

	name = names[0]

	prices = BeautifulSoup(_html).findAll("strong",{"class":"product-price"})

	price = prices[0]


# filename = "Coles-Beverage-Extraction.csv"
# f = open(filename, "w")

# headers = "Brand, Product, Price\n"

# f.write(headers)

	for brand in brands:
		brand = brand.text
		print("Brand: " + brand)

#	f.write(brands)

	for name in names:
		name = name.text
		print("Name: " + name)

#	f.write(names)

	for price in prices:
		price = price.text
		print("Price: " + price)

#	f.write(prices)

#f.close()