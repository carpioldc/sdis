import urllib
import sys
import os
from array import *
from lxml import html



NOT_FOUND = 1

def retrieve_image (img_elt):
    img_url = img_elt.xpath('attribute::src')[0]

    while img_url[0] == '/':    # Remove slashes
        img_url = img_url[1:]

    path = os.path.join(out_folder, img_url.split('/')[-1])
    urllib.urlretrieve('https://'+img_url, path)
    print 'image '
    return path

def main (name):
    director = dict()
    name = name.replace(' ', '_')
    base_url = "https://en.wikipedia.org/wiki/"
    page = html.fromstring(urllib.urlopen(base_url + name).read())
    print 'Parsing from {}... '.format(base_url+name)
    try:
        err_text = "Wikipedia does not have an article with this exact name."
        if page.xpath('//td[@class="mbox-text"]/b')[0].text.strip() == err_text:
            print 'not found on Wikipedia\n'
            return NOT_FOUND
    except IndexError:      # There is no such message
        pass
    
    print 'found: '
    bio = page.xpath('//table[@class="infobox biography vcard"]')
    if bio:
        img = bio[0].xpath('//img')
        if img:
            director['img'] = retrieve_image(img[0]) 
        bplace = bio[0].xpath('//span[@class="birthplace"]/text()')
        if bplace:
            director['birthplace'] = bplace[0].split(',')[-1].split()
            print 'birthplace '
        bday = bio[0].xpath('//span[@class="bday"]')
        if bday:
            director['date'] = bday[0].text.split()
            print 'birthday '
        print '\n\n'
    else:
        print 'bio info not found\n'
    
    print 'Name: {}\n'.format(name.replace('_', ' ')) 
    print 'Image: {}\n'.format(director['img'])
    print 'Birthday: {}\n'.format(director['date'])
    print 'Birthplace: {}\n'.format(director['birthplace'])
    
def _usage():
    print "Include name of the director as string parameter"

if __name__ == "__main__":
    name = sys.argv[-1]
    out_folder = "./images/"
    if not name:
        _usage()
        sys.exit(-1)
    main(name)
