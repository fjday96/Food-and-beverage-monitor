from urllib.request import urlopen as uReq
from bs4 import BeautifulSoup as soup

my_url = 'https://shop.coles.com.au/a/a-national/everything/browse/drinks/soft-drinks-3314551?pageNumber=1'

#opening up connection, grabbing the page
uClient = uReq(my_url)
page_html = uClient.read()
uClient.close()

#html parsing
page_soup = soup(page_html, "html.parser")

#grabs each product
products = page_soup.findAll("div",{"class":"colrs-animate tile-animate"})

print(products)
