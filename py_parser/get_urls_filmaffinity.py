import urllib
from array import *
from lxml import html

# URL
url = "http://www.filmaffinity.com/es/topgen.php"
base_url = "http://www.filmaffinity.com"

# Get HTML code
page = html.fromstring(urllib.urlopen(url).read())

url_list = []

url_html = page.xpath('//div[@class="mc-title"]/a/@href')

for i in url_html:
    url_list.append((base_url + i))

for i in url_list:
     print i
