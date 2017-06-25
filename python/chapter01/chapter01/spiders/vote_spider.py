import scrapy
class VoteSpider(scrapy.Spider):
    name = 'vote'
    def start_requests(self):
        urls = [
            'http://jxga.jxnews.com.cn/app/index.php?i=17&c=entry&do=index&m=alpha_vote&id=71&is_follow=1&rnd=1494640674&s_key=af2d4e9d1404d7b962bf9de2d36488d1',
        ]
        for url in urls:
            yield scrapy.Request(url=url,callback=self.parse)
    def parse(self, response):
        page = 1
        filename = 'votes-%s.html' % page
        with open(filename,'wb') as f:
            f.write(response.body)
        self.log('Save file %s' % filename)
