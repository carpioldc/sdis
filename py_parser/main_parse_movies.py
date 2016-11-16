import urllib
import sys
import csv
from array import *
from lxml import html
import os

def urls_from_fa_list():
    "Ask for the URL for the list to parse from. Default URL provided. Return a list of URLs corresponding to the movies on that list."
    global url_chart
    base_url = "http://www.filmaffinity.com"
    url_chart = raw_input("Enter list: ")
    if not url_chart:
        url_chart = "http://www.filmaffinity.com/en/topgen.php" # Default list
 
    page = html.fromstring(urllib.urlopen(url_chart).read())
    url_list = []                           
    url_html = page.xpath('//div[@class="mc-title"]/a/@href')  
    for i in url_html:
        url_list.append((base_url + i))
    return url_list           
    
def parse_film_page(url):
    "Parse movie info from the url given and return in a dictionary, using UTF-8 encoding"
    film = dict()
    sys.stdout.write ( 'Parsing from %s... ' % url)
    
    # Get HTML code
    page = html.fromstring(urllib.urlopen(url).read())

    # Parse fields from FILMAFFINITY
    info = page.xpath('//dl[@class="movie-info"]')[0]                                                       # HTML element with movie info
    film['title'] = info.xpath('//dd')[0].text.strip()                                                      # title
    film['year'] = info.xpath('//dd[@itemprop="datePublished"]/text()')[0].strip()                          # year
    film['duration'] = info.xpath('//dd[@itemprop="duration"]')[0].text.strip()                             # duration
    film['country'] = info.xpath('//dl[@class="movie-info"]//span[@id="country-img"]/../text()')[0].strip() # country
    film['director'] = info.xpath('//span[@itemprop="director"]/a/attribute::title')[0]                     # director
    film['genre'] = info.xpath('//span[@itemprop="genre"]')[0][0].text.strip()                              # genre
    film['description'] = info.xpath('//dd[@itemprop="description"]')[0].text.strip()                       # description
    film['img'] = page.xpath('//img[@itemprop="image"]/attribute::src')[0].strip()                          # image URL
    
    # Encode
    for i in film:
        film[i] = film[i].encode('UTF-8') 
    sys.stdout.write ( '{} done\n'.format(film['title']) )
    return film
   
#_________________________________MAIN_PROGRAM_________________________________

# Delete csv file in case it already exists
filename = "/tmp/movie_data.csv"
try:
    os.remove( filename )
except OSError:
    pass

url_list = urls_from_fa_list()
print 'List containing the movies: {}'.format(url_chart)
raw_input("Your chance to stop")

# Write fieldnames to file
with open( filename, 'ab' ) as csvfile:
    fieldnames = ['title', 'year', 'duration', 'country', 'director', 'genre', 'description', 'img']
    fwriter = csv.writer(csvfile)
    fwriter.writerow(fieldnames)

    for url in url_list:
        fwriter = csv.DictWriter(csvfile, fieldnames=fieldnames)
        fwriter.writerow(parse_film_page(url))
    
sys.stdout.write ( 'All fields written to %s\n' % filename )
sys.stdout.write ( 'Execute update_movie_tables.php to update the database\n' )
sys.stdout.flush()
