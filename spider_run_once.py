#! /usr/bin/python
# -*- coding: utf-8 -*-
# encoding=utf8

from selenium import webdriver
from urllib.request import urlopen as uReq
from bs4 import BeautifulSoup
import json
import urllib
import re
import requests
import math
import os
import csv
import cx_Oracle as orcl
from apscheduler.schedulers.background import BackgroundScheduler

scheduler = BackgroundScheduler(
    # timezone='Oceania/Australia',
    job_defaults={'misfire_grace_time': 60},
    )

class cloes:
    def getUrlList(self):
        list=[]
        url = ('https://shop.coles.com.au/a/a-vic-metro-burwood-east/everything/browse')
        res = requests.get(url)
        _html = res.text

        soup = BeautifulSoup(_html, "lxml")
        #<div style="display: none" aria-hidden="true" data-colrs-transformer="colrsExpandFilter" data-colrs-all-categories>
        json_str = soup.findAll("div", {"data-colrs-transformer": "colrsExpandFilter"})
        json_str = json_str[0].text
        # print(json_str)
        json_dic = json.loads(json_str)
        for l1 in json_dic['catalogGroupView']:
            # print('===========')
            for l2 in l1['catalogGroupView']:
                # print(l1['seo_token']+'/'+l2['seo_token'])
                list.append(l1['seo_token']+'/'+l2['seo_token'])
        return list
        pass
    def getColesJson(self,basicUrl,beginIndex = 0):
        # https://shop.coles.com.au/online/a-national/drinks/coffee-drinks-3314631?tabType=everything&tabId=everything&personaliseSort=false&orderBy=20601_6&errorView=AjaxActionErrorResponse&requesttype=ajax&beginIndex=0
        #view-source:https://shop.coles.com.au/online/COLRSHomePage?storeId=20501&catalogId=29102&langId=-1&tabType=specials&tabId=specials&personaliseSort=false&orderBy=20501_6&errorView=AjaxActionErrorResponse&requesttype=ajax&beginIndex=0
        cookies = {}  # 初始化cookies字典变量
        # coo ='firstVisit=1511850789.324; _ga=GA1.4.1086761500.1511850784; AMCVS_0B3D037254C7DE490A4C98A6%40AdobeOrg=1; WC_SESSION_ESTABLISHED=true; cache-generation=20171212T170003; JSESSIONID=0000GXs74oAtaDGNrYGePEzBHHK:1ajsau4e5; AMCV_0B3D037254C7DE490A4C98A6%40AdobeOrg=1099438348%7CMCMID%7C32981486158142619134099643846666660975%7CMCAAMLH-1513580796%7C11%7CMCAAMB-1513741145%7CRKhpRz8krg2tLO6pguXWp5olkAcUniQYPHaMWWgdJ3xzPWQmdj0y%7CMCOPTOUT-1513143545s%7CNONE%7CMCAID%7CNONE%7CvVersion%7C2.1.0; s_cc=true; WC_AUTHENTICATION_528285986=528285986%2Cyi4kbyJcy96WDITjBDaXBNw7Hew%3D; localisationCookie=10501|29102; rslc=20501|29102|12259; canBrowseRestrictedProductsFlag=1; JSRCH=000084Cz2a2qumHZgaveVcYIeXA:1a8jcd65g; WC_PERSISTENT=IHvz1wkdwcFtmzu7XujJCydW3NQ%3D%0A%3B2017-12-13+15%3A15%3A32.601_1513138524376-7951_20501; WC_ACTIVEPOINTER=-1%2C20501; mbox=PC#303b745a6cb64633a66a631cecfefee2.24_12#1575258451|session#a231b8963c784a6789b31d9917ea0208#1513140417; WC_USERACTIVITY_528285986=528285986%2C20501%2Cnull%2Cnull%2C1513138532601%2C1513140769357%2Cnull%2Cnull%2Cnull%2Cnull%2C5R%2FL%2FK3s1by7oSDVSR1PO3gRpRE270sQiIRF09Ox%2FQGf%2Fix%2B6CUTvNDTiDAfG7Dp8ssQJzde7ktY3cm5qNj%2BbLDB1K0hx6GE8GeaT8u4G3HFRga2f1iC4e1i6nqqwRsLDJLTEdyH6e5mwBtXCZdV3zTwDqEn7ILY8uevO7sXIZ00MELwkkfLB%2BE8w9SoH9RNa5wmgmpnChfTufCESVJ2mseKCdhv5U%2B8RUcDexJ2jOE%3D; UID=528285986|20501|1513138532601|R; _gat=1; s_sq=%5B%5BB%5D%5D; aam_uuid=26492258166063937593594519232722683241; nors2=0; _ga=GA1.3.1086761500.1511850784; _gid=GA1.3.238524145.1513136341; check=true'
        # for line in coo.split(';'):  # 按照字符：进行划分读取
        #     # 其设置为1就会把字符串拆分成2份
        #     name, value = line.strip().split('=', 1)
        #     cookies[name] = value  # 为字典cookies添加内容
        #https://shop.coles.com.au/online/a-vic-metro-burwood-east/christmas/christmas-bakery?tabType=everything&tabId=everything&personaliseSort=false&orderBy=20501_6&errorView=AjaxActionErrorResponse&requesttype=ajax&beginIndex=0

        beginIndex = str(beginIndex)
        paramater = 'tabType=everything&tabId=everything&personaliseSort=false&orderBy=20501_6&errorView=AjaxActionErrorResponse&requesttype=ajax&beginIndex=' + beginIndex
        url = (basicUrl + '?' + paramater)
        res = requests.get(url)
        _html = res.text

        soup = BeautifulSoup(_html, "lxml")

        # data-colrs-transformer="colrsExpandFilter"
        json_str = soup.findAll("div", {"data-colrs-transformer": "colrsExpandFilter"})
        json_str = json_str[0].text
        return json_str

    def getColes(self,basicUrl):
        print('Url:'+basicUrl)
        print('Scraping page 1...')
        json_str = self.getColesJson(basicUrl,0)

        list=[]
        returnList = self.analyze_coles_json(json_str)
        list.extend(returnList)


        json_dic = json.loads(json_str)
        totalCount = int(json_dic['searchInfo']['totalCount'])
        totalPage = math.ceil(totalCount / 24)
        print('total page number:'+ str(totalPage))
        for j in range(totalPage):
            if j !=0:
                print('Scraping page ' + str(j+1) + '...')
                json_str = self.getColesJson(basicUrl, 24 * j)
                returnList = self.analyze_coles_json(json_str)
                list.extend(returnList)


        return list

    def analyze_coles_json(self,source):
        json_dic = json.loads(source)
        list = []
        for i in range(len(json_dic['products'])):
            try:
                item = json_dic['products'][i]
                # print('牌子' + item['m'])
                # print('商品名' + item['n'])
                originalPrice = None
                special = None
                if len(item['p1']) == 2:
                    # print('原价' + item['p1']['l4'])
                    originalPrice = item['p1']['l4']
                    # print('special: True')
                    special = True
                    currentPrice = item['p1']['o']
                    cupString = item['u2']
                elif len(item['p1']) == 1:
                    # print('原价' + item['p1']['o'])
                    originalPrice = item['p1']['o']
                    # print('special: False')
                    special = False
                    currentPrice = item['p1']['o']
                    cupString = item['u2']
                else:
                    originalPrice = 0
                    special = False
                    currentPrice = 0

                if special:
                    discountPercentage = format(float(currentPrice) / float(originalPrice) * 100, '.2f')
                else:
                    discountPercentage = 0
                # print('折扣' + str(discountPercentage))

                url = 'https://shop.coles.com.au' + item['t']

                if ('O3' in item['a'].keys()):
                    packageSize = item['a']['O3'][0]
                    unitWeight = item['a']['O3'][0]
                else:
                    packageSize = None
                    unitWeight = None
                if ('pd' in item.keys()):
                    moreLowPrice = item['pd']
                else:
                    moreLowPrice = None
            except Exception as e:
                print(e)
                print(json.dumps(item))
                os._exit(0)
            # print(url)
            # print('')
            list.append([item['m'], item['n'], originalPrice, currentPrice, discountPercentage, special, moreLowPrice, url, cupString,packageSize,unitWeight])

        return list

class woolworth:
#得到woolworthes的Nodeid
    def getWoolList(self):
        url = ('https://www.woolworths.com.au/shop/browse/drinks/soft-drinks')
        cookies = {'sf-locationId': '5359', 'sf-locationName': 'Woolworths%20Box%20Hill%20store%2C%203128'}
        # cookies = {}  # 初始化cookies字典变量
        # coo='ASP.NET_SessionId=vh31xzdkaj3xgmreeaut5gsu; w-rsjhf=PGcgdD0iOWY1MDljM2U5OWU2NDk1ODllNmQ4N2U5NTZiYzZjYjhwcm10b3dtZ294IiAvPg==; ARRAffinity=ee8f1499afa8f0e354edfb422f122da60dcd65f5ef3e447bf579a5e591c0d928; w-arjshtsw=z4a8753b6254f46fea71e815a32644fadzxttqnlud; AMCVS_4353388057AC8D357F000101%40AdobeOrg=1; rr_rcs=eF4FwbENgDAMBMCGil1eyju24xFYw8GKREEHzM_dtr3nMZNmqRMZIdCqRIkXXG2syemr-35_z1XCzgYapWnEcNcONgL8Aca2Ejs; _vis_opt_s=1%7C; __utmt_UA-38610140-1=1; cvo_tid1=BQLkeMovHcI|1512048876|1512048876|4; mbox=session#f650171f97da41f1839867b2746135b4#1512050741|PC#f650171f97da41f1839867b2746135b4.27_14#1575293681; AAMC_wfg_0=REGION%7C8; aam_uuid=01655714456560786413593451850204566563; ADRUM=s=1512048951030&r=https%3A%2F%2Fwww.woolworths.com.au%2Fshop%2Fbrowse%2Fdrinks%2Fsoft-drinks%3F0; _sdsat_User: Profile: ProfileInfo: ShopperID=0; check=true; _vwo_uuid_v2=CAD917587E24BA382C68CE324CE6B35D|03f09f2caffe6ae8f25c90ab7c7e2f56; AMCV_4353388057AC8D357F000101%40AdobeOrg=1406116232%7CMCIDTS%7C17501%7CMCMID%7C02103418294402009413565148821998468607%7CMCAAMLH-1512653751%7C8%7CMCAAMB-1512653751%7CRKhpRz8krg2tLO6pguXWp5olkAcUniQYPHaMWWgdJ3xzPWQmdj0y%7CMCCIDH%7C-1838828971%7CMCOPTOUT-1512056077s%7CNONE%7CMCAID%7CNONE%7CMCSYNCSOP%7C411-17508%7CvVersion%7C2.5.0; cvo_sid1=G8KN256YMG8R; _vis_opt_test_cookie=1; __utma=153838014.308831495.1512048879.1512048880.1512048880.1; __utmb=153838014.2.10.1512048880; __utmc=153838014; __utmz=153838014.1512048880.1.1.utmcsr=(direct)|utmccn=(direct)|utmcmd=(none); _dc_gtm_UA-38610140-4=1; _ga=GA1.3.308831495.1512048879; _gid=GA1.3.1589211050.1512048879; _gat_UA-38610140-9=1'
        # for line in coo.split(';'):  # 按照字符：进行划分读取
        #     # 其设置为1就会把字符串拆分成2份
        #     name, value = line.strip().split('=', 1)
        #     cookies[name] = value  # 为字典cookies添加内容
        # print(cookies['AAMC_wfg_0'])

        res = requests.get(url,cookies=cookies)
        _html = res.text

        soup = BeautifulSoup(_html, "lxml")
        # save('html.txt', _html)
        jses = soup.findAll("script")
        js_analyze = ''
        for js in jses:
            js = js.text
            if "window.wowBootstrap" in js:
                # print(js)
                js_analyze = js
        # save('json.txt', js_analyze)

        #删除首尾window.wowBootstrap =  ;
        js_analyze = js_analyze.strip()
        js_analyze = js_analyze.replace('window.wowBootstrap =', '')
        js_analyze = js_analyze.strip(';')
        # print(js_analyze)
        json_ana = json.loads(js_analyze)
        l1 = json_ana['ListAllPiesCategoriesWithSpecialsRequest']['Categories']
        l2 = []
        l3 = []
        for i in range(len(l1)):
            for j in range(len(l1[i]['Children'])):
                l2.append(l1[i]['Children'][j])
                for k in range(len(l1[i]['Children'][j]['Children'])):
                    l3.append(l1[i]['Children'][j]['Children'][k])
                    # if(len(l1[i]['Children'][j]['Children'][k]['Children'])!=0):
                    #     print(len(l1[i]['Children'][j]['Children'][k]['Children']))
                    # # for l in range(len(l1[i]['Children'][j]['Children'][k]['Children'])):
                    # #     l3.append(l1[i]['Children'][j]['Children'][k])
        # print(len(l1))
        # print(len(l2))
        # print(len(l3))
        return [l1,l2,l3]

#传入商品字典
    def getWoolItem(self,item):

        print('******')
        print("Now analyzing:")
        print("NodeId:" + item['NodeId'])
        print("Description:" + item['Description'])

        list = []
        for i in range(1000):
            i=i+1
            print('analyzing page '+str(i)+'...')
            # 'location': '/shop/browse/drinks/soft-drinks',
            # 'url': '/shop/browse/drinks/soft-drinks'
            data = {'categoryId': item['NodeId'],
                 'filters': None,
                 'formatObject': '{"name":"'+item['Description']+'"}',
                 'isBundle': False,
                 'isMobile': False,
                 'isSpecial': False,
                 'location': '/',
                 'pageNumber': i,
                 'pageSize': 36,
                 'sortType': 'TraderRelevance',
                 'url': '/'}
            # print(data)
            url = 'https://www.woolworths.com.au/apis/ui/browse/category'
            cookies = {}  # 初始化cookies字典变量
            # coo = 'ASP.NET_SessionId=vh31xzdkaj3xgmreeaut5gsu; w-rsjhf=PGcgdD0iOWY1MDljM2U5OWU2NDk1ODllNmQ4N2U5NTZiYzZjYjhwcm10b3dtZ294IiAvPg==; ARRAffinity=ee8f1499afa8f0e354edfb422f122da60dcd65f5ef3e447bf579a5e591c0d928; w-arjshtsw=z4a8753b6254f46fea71e815a32644fadzxttqnlud; AMCVS_4353388057AC8D357F000101%40AdobeOrg=1; rr_rcs=eF4FwbENgDAMBMCGil1eyju24xFYw8GKREEHzM_dtr3nMZNmqRMZIdCqRIkXXG2syemr-35_z1XCzgYapWnEcNcONgL8Aca2Ejs; _vis_opt_s=1%7C; __utmt_UA-38610140-1=1; cvo_tid1=BQLkeMovHcI|1512048876|1512048876|4; mbox=session#f650171f97da41f1839867b2746135b4#1512050741|PC#f650171f97da41f1839867b2746135b4.27_14#1575293681; AAMC_wfg_0=REGION%7C8; aam_uuid=01655714456560786413593451850204566563; ADRUM=s=1512048951030&r=https%3A%2F%2Fwww.woolworths.com.au%2Fshop%2Fbrowse%2Fdrinks%2Fsoft-drinks%3F0; _sdsat_User: Profile: ProfileInfo: ShopperID=0; check=true; _vwo_uuid_v2=CAD917587E24BA382C68CE324CE6B35D|03f09f2caffe6ae8f25c90ab7c7e2f56; AMCV_4353388057AC8D357F000101%40AdobeOrg=1406116232%7CMCIDTS%7C17501%7CMCMID%7C02103418294402009413565148821998468607%7CMCAAMLH-1512653751%7C8%7CMCAAMB-1512653751%7CRKhpRz8krg2tLO6pguXWp5olkAcUniQYPHaMWWgdJ3xzPWQmdj0y%7CMCCIDH%7C-1838828971%7CMCOPTOUT-1512056077s%7CNONE%7CMCAID%7CNONE%7CMCSYNCSOP%7C411-17508%7CvVersion%7C2.5.0; cvo_sid1=G8KN256YMG8R; _vis_opt_test_cookie=1; __utma=153838014.308831495.1512048879.1512048880.1512048880.1; __utmb=153838014.2.10.1512048880; __utmc=153838014; __utmz=153838014.1512048880.1.1.utmcsr=(direct)|utmccn=(direct)|utmcmd=(none); _dc_gtm_UA-38610140-4=1; _ga=GA1.3.308831495.1512048879; _gid=GA1.3.1589211050.1512048879; _gat_UA-38610140-9=1'
            coo='sf-locationId=5359; sf-locationName=Woolworths%20Box%20Hill%20store%2C%203128; sf-shownsale-19612=1; ASP.NET_SessionId=npvn0hrcxpusrlpvcjt1k0aq; AMCVS_4353388057AC8D357F000101%40AdobeOrg=1; _vis_opt_s=3%7C; sf-shoppinglist=%5B%7B%22itemId%22%3A%22196121004%22%7D%5D; ARRAffinity=d43c6cc5772b057656cd8493e7ac3927022e50ec1f5d0f6267105531ea201e58; IR_gbd=woolworths.com.au; IR_PI=1512056600288.oz96lf0q09; s_dfa=woolstelco-prod%2Cwoolsglobal-prod; s_getDaysSinceLastVisit=1512056602913; s_getDaysSinceLastVisit_s=First%20Visit; w-arjshtsw=zedfa0e4810124662beaae0fc24a2851dzgxmkylew; inbenta-iaf-jsonp=goa0t5pre7796m7lh2erfh8q17; previousPage=%23view%3Dsearch%26saleId%3D19612%26keyword%3DBundaberg%2520Traditional%2520Lemonade; __utmt_UA-38610140-1=1; w-lrkswrdjp=dm-Courier,f-3151,s-4225; w-rsjhf=PGcgLz4=; s_cc=true; s_sq=%5B%5BB%5D%5D; _gat_UA-38610140-9=1; cvo_tid1=AdtrQaBDGPM|1511850161|1512058005|0; mbox=PC#95a109d00bea4ddfa41c6e430ac9526d.26_2#1575302249|session#b50c3f0dcb1846c28574fe65682fe754#1512059868; rr_rcs=eF5jYSlN9jBPTUozTE611DUwSUrTNTExALIsDAx0E1NNgZRJkqlhsiFXbllJZoqeobGhga6hqaGRAUjKwsDcUNdYV9cQAIo3ESo; AAMC_wfg_0=REGION%7C6%7CAMSYNCSOP%7C%7CAMSYNCS%7C; aam_uuid=26492258166063937593594519232722683241; ADRUM=s=1512058034622&r=https%3A%2F%2Fwww.woolworths.com.au%2Fshop%2Fsearch%2Fproducts%3F1139050664; check=true; cvo_sid1=7AAAXU66ZF9D; __utma=153838014.775062744.1511850653.1512050452.1512056466.10; __utmb=153838014.15.10.1512056466; __utmc=153838014; __utmz=153838014.1512050452.9.3.utmcsr=google|utmccn=(organic)|utmcmd=organic|utmctr=(not%20provided); _dc_gtm_UA-38610140-4=1; _ga=GA1.3.775062744.1511850653; _gid=GA1.3.1692328667.1512016375; _vwo_uuid_v2=EB56E462E6C9D2CF09842A25DC0873B1|e0860fe662c15b7b093343c4d34868b5; _vis_opt_test_cookie=1; _sdsat_User: Profile: ProfileInfo: ShopperID=0; AMCV_4353388057AC8D357F000101%40AdobeOrg=1406116232%7CMCIDTS%7C17501%7CvVersion%7C2.5.0%7CMCMID%7C26223641195735562913550312804181994677%7CMCAAMLH-1512662842%7C6%7CMCAAMB-1512662842%7CRKhpRz8krg2tLO6pguXWp5olkAcUniQYPHaMWWgdJ3xzPWQmdj0y%7CMCCIDH%7C-1838828971%7CMCOPTOUT-1512063662s%7CNONE%7CMCAID%7CNONE%7CMCSYNCSOP%7C411-17508'
            for line in coo.split(';'):  # 按照字符：进行划分读取
                # 其设置为1就会把字符串拆分成2份
                name, value = line.strip().split('=', 1)
                cookies[name] = value  # 为字典cookies添加内容
            # cookies = {'sf-locationId': '5359','sf-locationName':'Woolworths%20Box%20Hill%20store%2C%203128'}
            # print(cookies['AAMC_wfg_0'])
            request = requests.post(url, json=data,cookies=cookies)
            # print(request.text)
            returnList = self.analyze_wool_json(request.text)
            if len(list)==0:
                list=returnList
            else:
                list.extend(returnList)
            # print(len(list))
            if len(returnList) < 36 :
                break

        return list

#将json解析为list
    def analyze_wool_json(self,source):
        # print('=====json=====')
        # print(source)
        jsobject = json.loads(source)
        list = []
        for i in range(len(jsobject['Bundles'])):
            item = jsobject['Bundles'][i]['Products'][0]
            # print(item)
            moreLowrPrice = None
            if item['IsCentreTag']:
                # print(item['CentreTag']['TagContent'])
                soup = BeautifulSoup(item['CentreTag']['TagContent'], "lxml")
                try:
                    moreLowrPrice = soup.findAll("a")[0].text
                except Exception as err:
                    pass
                    # print("1======")
                    # try:
                    #     moreLowrPrice = soup.findAll("span")[0].text
                    # except Exception as err:
                    #     # print("2======")
                    #     # No further discounts
                    #     # moreLowrPrice = item['CentreTag']['TagContent']
                    #     pass

            # if moreLowrPrice !=None:
            #     print(moreLowrPrice)
            special = item['IsOnSpecial']
            currentPrice = item['Price']
            originalPrice = item['WasPrice']
            if item['CupString'] != '$0.00 / 0':
                cupString = item['CupString']
            else:
                cupString = None

            packageSize = item['PackageSize']
            unitWeight = item['UnitWeightInGrams']

            if special:
                discountPercentage = format(float(currentPrice) / float(originalPrice) * 100, '.2f')
            else:
                discountPercentage = 0
            list.append([item['Brand'], item['Name'], originalPrice, currentPrice,discountPercentage, special, moreLowrPrice, item['LargeImageFile'],cupString,packageSize,unitWeight])
        return list

class database:
    def __init__(self):
        self.host = "aacmfd71r5px9r.cl6xpzchktcy.us-west-2.rds.amazonaws.com"
        self.port = "1521"
        self.sid = "EBDB"
        self.username = 'jpedler'
        self.password = 'databasePassword'

    def connect(self):
        dsn = orcl.makedsn(self.host, self.port, self.sid)
        self.conn = orcl.connect(self.username, self.password, dsn)
        self.c = orcl.Cursor(self.conn)

    def close(self):
        self.c.close()
        self.conn.close()

    def save(self, brand, name, originalprice, price, discountpercentage, special, multibuy, imageurl, store):

        if brand == None:
            brand =''
        else:
            brand = str(brand)

        if name == None:
            name =''
        else:
            name = str(name)

        if originalprice == None:
            originalprice =''
        else:
            originalprice = str(originalprice)

        if price == None:
            price =''
        else:
            price = str(price)

        if discountpercentage == None:
            discountpercentage =''
        else:
            discountpercentage = str(discountpercentage)

        if special == None:
            special =''
        else:
            special = str(special)

        if multibuy == None:
            multibuy =''
        else:
            multibuy = str(multibuy)

        if imageurl == None:
            imageurl =''
        else:
            imageurl = str(imageurl)



        brand = brand.replace("'","''")
        name = name.replace("'","''")
        name = name.replace("è", "e")


        # print("SELECT count(*) FROM productdb WHERE brand='"+brand+"' AND name='"+name+"'")
        # try:
        x = self.c.execute(u"SELECT count(*) FROM productdb WHERE brand='"+brand+"' AND name='"+name+"'")
        # except Exception as e:
        #     print(brand)
        #     print(name)
        #     print(u"SELECT count(*) FROM productdb WHERE brand='" + brand + "' AND name='" + name + "'")
        result = x.fetchall()
        num = result[0][0]

        if num == 1:
            product_exist = True
        else:
            product_exist = False


        if product_exist:
            sql = "UPDATE productdb SET price='"+price+"', discountpercentage='"+discountpercentage+"', special='"+special+"', multibuy='"+multibuy+"', imageurl='"+imageurl+"', store='"+store+"' WHERE brand='"+brand+"' AND name='"+name+"'"
            self.c.execute(sql)
            # print('')
            # print(sql)
            self.conn.commit()
            pass
        else:
            x = self.c.execute('SELECT count(*) FROM productdb')
            result = x.fetchall()
            # num: exist row num
            num = result[0][0]
            self.conn.commit()
            sql = "INSERT INTO productdb (id, brand, name, originalprice, price, discountpercentage, special, multibuy, imageurl, store)VALUES("+str(num+1)+", '"+brand+"', '"+name+"', '"+originalprice+"', '"+price+"', '"+discountpercentage+"', '"+special+"', '"+multibuy+"', '"+imageurl+"', '"+store+"')"
            self.c.execute(sql)
            # print('')
            # print(sql)
            self.conn.commit()
            pass

def saveDatabase(list,store):
    db = database()
    db.connect()
    for i in range(len(list)):
        item = list[i]
        #brand, name, originalprice, price, discountpercentage, special, multibuy, imageurl, store
        try:
            db.save(item[0],item[1],item[2],item[3],item[4],item[5],item[6],item[7],store)
        except Exception as e:
            print('@@@@@@@@@@@@@@@@@@')
            print(e)
            print('@@@@@@@@@@@@@@@@@@')
    db.close()

def createCSV(filename):
    with open(filename, "w", newline="") as datacsv:
        csvwriter = csv.writer(datacsv, dialect=("excel"))
        csvwriter.writerow(["Brand", "Name", "OriginalPrice", "Price", "DiscountPercentage", "Special", "MoreLowrPrice", "LargeImageFile","CupString", "PackageSize", "UnitWeight", "Catalogue"])

#将list保存到CSV
def saveCSV(filename,Catalogue,list):


    with open(filename, "a", newline="") as datacsv:
        csvwriter = csv.writer(datacsv, dialect=("excel"))

        for i in range(len(list)):
            item = list[i]
            csvwriter.writerow([item[0], item[1], item[2],item[3], item[4], item[5], item[6],item[7],item[8],item[9],item[10],Catalogue])


# ========================

#WoolWorths
@scheduler.scheduled_job('cron', hour='0', minute='0')
def woolworth_spider():
    wl = woolworth()
    [l1,l2,l3] = wl.getWoolList()
    filename = "woolworth_.csv"
    createCSV(filename)
    print('**************')
    for item in l1:
        if item['Description'] != 'Front of Store' and item['Description'] != 'Health & Beauty' and item['Description'] != 'Household' and item['Description'] != 'Pet' and item['Description'] != 'Specials':
            print(item['Description'])
    print('**************')
    for item in l1:
        if item['Description'] != 'Front of Store' and item['Description'] != 'Health & Beauty' and item['Description'] != 'Household' and item['Description'] != 'Pet' and item['Description'] != 'Specials':
            # print(item['NodeId']+" "+item['Description'])
            # print(item)

            itemList = wl.getWoolItem(item)
            # print(itemList)
            print(len(itemList))
            saveCSV(filename,item['Description'],itemList)

            # try:
            saveDatabase(itemList, 'Woolworths')
            # except Exception as e:
            #     print('@@@@@@@@@@@@@@@@@@')
            #     print(e)
            #     print('@@@@@@@@@@@@@@@@@@')


#========================

#Coles

#'https://shop.coles.com.au/a/a-national/specials/browse',

#https://shop.coles.com.au/online/a-national/christmas/christmas-bakery

@scheduler.scheduled_job('cron', hour='1', minute='0')
def coles_spider():
    c = cloes()
    urls = c.getUrlList()
    flag = False
    filename = "coles_.csv"
    createCSV(filename)
    print('**************')
    for url in urls:
        if not ('pet' in url) and \
                not ('clothing' in url) and \
                not ('stationery' in url) and \
                not ('tobacco' in url) and \
                not ('household' in url) and \
                not ('accessories' in url) and \
                not ('nappies' in url) and \
                not ('beauty' in url):
            print(url)

        pass
    print('**************')
    for url in urls:
        if not('pet' in url) and \
                not('clothing' in url) and \
                not('stationery' in url) and \
                not('tobacco' in url) and \
                not('household' in url) and \
                not('accessories' in url) and \
                not ('nappies' in url) and \
                not ('beauty' in url):
            # if 'dairy-eggs' in url:
            basicUrl = 'https://shop.coles.com.au/online/a-vic-metro-burwood-east/'+url
            itemList = c.getColes(basicUrl)

            pat = re.compile('^' + '(.*?)' + '/', re.S)
            result = pat.findall(url)
            catalogue = result[0].replace("--", "-").replace("-", " & ")
            print('save as '+catalogue)
            saveCSV(filename,catalogue,itemList)
            # try:
            saveDatabase(itemList,'Coles')
            # except Exception as e:
            #     print('@@@@@@@@@@@@@@@@@@')
            #     print(e)
            #     print('@@@@@@@@@@@@@@@@@@')
            print('==========')

coles_spider()
woolworth_spider()

def showDatabase():

    host = "aacmfd71r5px9r.cl6xpzchktcy.us-west-2.rds.amazonaws.com"
    port = "1521"
    sid = "EBDB"
    username='jpedler'
    password='databasePassword'
    dsn = orcl.makedsn(host, port, sid)
    conn = orcl.connect(username, password, dsn)
    c = orcl.Cursor(conn)

    # CREATE TABLE productdb(
    # id NUMBER(6) NOT NULL, brand VARCHAR2(40) NOT NULL, name VARCHAR2(50) NOT NULL, originalprice VARCHAR2(10) NOT NULL, price VARCHAR2(10) NOT NULL, discountpercentage VARCHAR2(10) NOT NULL, special VARCHAR2(5) NOT NULL, multibuy VARCHAR2(50), imageurl VARCHAR2(200) NOT NULL, store VARCHAR2(20) NOT NULL, PRIMARY KEY (id)
    # );

    print('======table======')
    x=c.execute('select * from productdb WHERE id=11000')
    result = x.fetchall()
    print(result)
    for r in result:
        print(r)
# showDatabase()

# scheduler.start()
# print("Running...")
# input()