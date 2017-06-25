# -*- coding: utf-8 -*-

# Define your item pipelines here
#
# Don't forget to add your pipeline to the ITEM_PIPELINES setting
# See: http://doc.scrapy.org/en/latest/topics/item-pipeline.html

import codecs
import json

class CitySpiderPipeline(object):
    def __init__(self):
        self.file = codecs.open('cities.txt',mode="wb",encoding='utf-8')
    def process_item(self, item, spider):
        if(item['name']):
            line = '('+str(item['id'])+',  '+str(item['parent_id'])+',  "'\
                   +item['name'][0].strip()+'",  "'+item['en_name'][0]+'",  "http:'+item['url'][0]+'"),\n'
            #json.dumps(dict(item))+"\n"
            #print("$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$")
            #print(item)
            self.file.write(line)
            #return item
