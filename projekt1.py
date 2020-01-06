#!/usr/bin/env python
# coding: utf-8

# In[1]:


from scrapy import Spider
from scrapy.crawler import CrawlerProcess #analogiczny mechanizm powinien być uruchamiany przy pomocy polecenia scrapy


# In[2]:


import logging
import os


# In[3]:


def try_remove(filename):
    try:
        os.remove('filename')
    except OSError:
        pass


# In[ ]:





# In[4]:


class BookingComOpinions(Spider):
    name = 'BookingComOpinionsSpider'
    
    custom_settings = {
        'FEED_URI': '%(json_file)s',
        'FEED_FORMAT': 'json',
        'DOWNLOAD_DELAY': 3,
        'LOG_LEVEL': logging.DEBUG,
        'EXTENSIONS': {
            'scrapy.extensions.closespider.CloseSpider': 1
        },
        'CLOSESPIDER_ITEMCOUNT': 10
    }
    
    def parse (self, response):
        hotels = response.css('div.sr_item')
        for hotel in hotels:
            hotel_name = hotel.css('span.sr-hotel__name::text').get().strip()
            for hotel_link in hotel.css('.hotel_name_link.url'):
                yield response.follow(hotel_link, self.parse_hotel, meta={'hotel': hotel_name})
        
        for link in response.css('a[data-page-next]'):
            yield response.follow(link)
            
    def parse_hotel (self, response):
        hotel_name = response.meta['hotel']
        for reviews_link in response.css('a.show_all_reviews_btn'):
            yield response.follow(reviews_link, self.parse_reviews, meta={'hotel': hotel_name})
        
    def parse_reviews(self, response):
        hotel_name = response.meta['hotel']
        items = response.css('li.review_item')
        for item in items:
            publish_date = item.css('meta[itemprop="datePublished"]'
                                    '::attr(content)').get('')
            reviewer = item.css('div.review_item_reviewer')
            rev_count = reviewer.css('div.review_item_user_review_count::text').get('')
            
            review = item.css('div.review_item_review')
            rating = review.css('meta[itemprop="ratingValue"]'
                                    '::attr(content)').get('')
            raw_tags = review.css('li.review_info_tag::text').getall()
            tags = list(filter(None, map(str.strip, raw_tags)))

            yield {
                'hotel': hotel_name,
                'publish_date': publish_date,
                'rev_count': rev_count,
                'rating': rating,
                'tags': tags
            }
            
            
        
        for next_page in response.css('a#review_next_page_link'):
            yield response.follow(next_page, self.parse_reviews,
                                 meta = response.meta)


# In[5]:


ENTRY_URL = 'https://www.booking.com/searchresults.pl.html?label=gen173nr-1FCAEoggI46AdIM1gEaLYBiAEBmAEeuAEXyAEP2AEB6AEB-AELiAIBqAIDuALs-JzlBcACAQ&sid=4082e00361337fcbf89e3697ab7fef29&sb=1&src=index&src_elem=sb&error_url=https%3A%2F%2Fwww.booking.com%2Findex.pl.html%3Flabel%3Dgen173nr-1FCAEoggI46AdIM1gEaLYBiAEBmAEeuAEXyAEP2AEB6AEB-AELiAIBqAIDuALs-JzlBcACAQ%3Bsid%3D4082e00361337fcbf89e3697ab7fef29%3Bsb_price_type%3Dtotal%26%3B&ss=Zakopane&is_ski_area=0&checkin_year=&checkin_month=&checkout_year=&checkout_month=&group_adults=2&group_children=0&no_rooms=1&b_h4u_keep_filters=&from_sf=1'


# In[ ]:





# In[6]:


json_file = 'zakopane.json'
#try_remove(json_file)


# In[7]:


process = CrawlerProcess()
process.crawl(BookingComOpinions, start_urls=[ENTRY_URL],json_file=json_file)


# In[8]:


#process.start()


# In[10]:


logging.getLogger().setLevel(logging.INFO)


# In[11]:


import pandas as pd


# In[13]:


df = pd.read_json(json_file)


# In[30]:


df['rev_count'] = df['rev_count'].str.strip('opinia') #data frame


# In[32]:


df['rev_count'] = df['rev_count'].astype(int)


# In[33]:


df.info()


# In[34]:


df #zmienne kateogryczne albo indyfikatorowe (dummies) - kolumna tags


# In[35]:


subdf = df[['rating','tags']]


# In[39]:


dum = subdf['tags'].map(lambda tags: '|'.join(tags)).str.get_dummies()


# In[43]:


indicators = pd.concat([subdf['rating'], dum], axis = 1) #ważne! trzeba uważać jak kontatujemy 


# In[49]:


melted = pd.melt(indicators, id_vars=['rating'])


# In[53]:


positive = melted['value'] == 1


# In[57]:


selected = melted[positive]
aggregated = selected.groupby(['variable'])['rating'].agg({'mean','count'})
aggregated.sort_values(by=['count']).tail(10)

