import urllib
from array import *
from lxml import html

# URL
url = "http://www.filmaffinity.com/en/film656153.html"

# Raw HTML page
page = html.fromstring(urllib.urlopen(url).read())

# Lists
#fields = ['titulo', 'ano', 'duracion', 'pais', 'director', 'guion', 'musica', 'fotografia', 'genero', 'sinopsis']
fields = ['title', 'year', 'duration', 'country', 'director', 'genre', 'description', 'img'] #, 'sinopsis']
film = dict()

# Parse fields from FILMAFFINITY
info = page.xpath('//dl[@class="movie-info"]')[0]           # HTML element with movie info
film['title'] = info.xpath('//dd')[0].text.strip()                         # titulo
film['year'] = info.xpath('//dd[@itemprop="datePublished"]/text()')[0]                      # ano
film['duration'] = info.xpath('//dd[@itemprop="duration"]')[0].text.strip()                 # duracion
film['country'] = info.xpath('//dl[@class="movie-info"]//span[@id="country-img"]/../text()')[0].strip()                         # pais
film['director'] = info.xpath('//span[@itemprop="director"]/a/attribute::title')[0]                                              # director
film['genre'] = info.xpath('//span[@itemprop="genre"]')[0][0].text.strip()                                # genre
film['description'] = info.xpath('//dd[@itemprop="description"]')[0].text.strip()                                # sinopsis
film['img'] = page.xpath('//img[@itemprop="image"]/attribute::src')[0].strip()
# Show what we've done
for f in fields :
#    print f + ': [' + film[f] + ']'
    try:
        print f + ': [' + film[f].encode('UTF-8') + ']'
    except UnicodeEncodeError:
        pass
