import scrapy
import sys
sys.path.append("..")
from scrapy import log
from scrapy.loader import ItemLoader
from city_spider.items import ContinentItem,NationItem,CityItem


class CitySpider(scrapy.Spider):
    name = 'citySpider'
    city_count = 0
    def start_requests(self):
        #allowed_domains = ['place.qyer.com']
        urls = [
            'http://place.qyer.com/#countrytab',
        ]
        for url in urls:
            yield scrapy.Request(url=url,callback=self.parse)
    def parse(self, response):
        # 解析七大洲
        continents = response.xpath("//div[@class='pla_indallworld']"
                                    "/div[@class='pla_indcountrylists']"
                                    "//div[@class='pla_indcountrylist clearfix']"
                                    "/h2[@class='title clearfix']/em")
        for continent in continents:
            item = ContinentItem()
            item['url'] = continent.xpath('a/@href').extract()
            title = continent.xpath('a/text()').extract()
            tmp = title[0].split(' ', 1)
            item['name'] = [tmp[0]]
            item['en_name'] = [tmp[1]]
            yield item
        # 解析每个国家
        fix_nation_urls = []
        nations = response.xpath("//div[@class='pla_indallworld']"
                                 "/div[@class='pla_indcountrylists']"
                                 "/div[@class='pla_indcountrylist clearfix']"
                                 "//ul[@class='list']"
                                 "/li[@class='item']")
        for nation in nations:
            item = NationItem()
            url = nation.xpath('a/@href').extract()
            id = nations.index(nation)
            item['id'] = nations.index(nation)
            item['parent_id'] = 0
            item['name'] = nation.xpath('a/text()').extract()
            item['en_name'] = nation.xpath('a/span[@class="en"]/text()').extract()
            item['url'] = [url[0] + 'citylist-1-0-1/'] if len(url) else ['']
            yield item
            if (len(url)):
                fix_nation_urls.append({"id":id+1,"url":"http:" + url[0] + 'citylist-1-0-1/'})
        self.city_count = self.city_count+len(nations)
        for url in fix_nation_urls:
            yield scrapy.Request(url=url['url'], callback=self.parseCity,meta={'parent_id':url['id']})

    #解析每个城市
    def parseCity(self,response):
        parent_id = response.meta['parent_id']
        cities = response.xpath("//div[@class='plcContainer']"
                                "/div[@class='qyWrap']"
                                "/div[@class='qyMain fl']"
                                "/ul[@class='plcCityWordlist']"
                                "//li//a")
        for city in cities:
            item = CityItem()
            url = city.xpath('@href').extract()
            i = cities.index(city)
            item['id']= i+self.city_count+1
            item['parent_id'] = parent_id
            item['name'] = city.xpath('text()').extract()
            item['en_name'] = city.xpath('span[@class="en"]/text()').extract()
            item['url'] =url if len(url) else ['']
            yield item
        self.city_count = self.city_count + len(cities)


