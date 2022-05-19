# TME长音频实时入库接口

## 安装

```
composer require kydever/tme-sdk
```

## 使用

跟 TME 官方人员沟通申请 `appid` `secret` 并拿到对应的文档，其中包含测试环境和线上环境的 `base_uri`

## 结构体

Chapter

```json
{
  "name": "测试书籍第1章", // 单集名称
  "location": 1, // 曲序(从1开始计数)
  "language": 0, // 语言
  "number": "rdxxx", // 传输方用于唯一标识章节的编码
  "publishTime": "2020-03-25 00:00:00", // 发行时间
  "audioUrl": "http://xxx/1.mp3", // 音频链接
  "transName": "", // 单集翻译名
  "otherName": "", // 单集其他名
  "saleTime": "0000-00-00 00:00:00" // 上线时间(为 0000-00-00 00:00:00 表示不自动上线)
}
```

Book

```json
{
  "company": "公司名", // 传输方名
  "name": "测试书籍", // 书籍名
  "number": "rdxxx", // 传输方用于唯一标识的书籍编码
  "scheduleStatus": 1, // 连载状态
  "area": 0, // 书籍地区
  "type": 101, // 节目主类型
  "language": "0", // 书籍语言(多个以逗号隔开)
  "photoUrl": "http://xxx/book.jpg", // 书籍图片
  "publishTime": "2020-03-25 00:00:00", // 发行时间
  "transName": "", // 书籍翻译名
  "otherName": "", // 书籍其他名
  "description": "", // 书籍简介
  "originalWorkName": "", // 原著作品名
  "originalPublishTime": "2010-01-01 00:00:00", // 原著发行时间
  "saleTime": "0000-00-00 00:00:00" // 上线时间(为 0000-00-00 00:00:00 表示不自动上线)
}
```

Singer

```json
{
  "name": "主播1", // 主播名
  "sort": 0 // 主播顺序(从 0 开始计数)
}
```

Track

```json
{
  "name": "测试书籍第3章", // 单集名称
  "location": 1, // 曲序(从 1 开始计数)
  "language": 0, // 语言
  "number": "rdxxx", // 传输方用于唯一标识章节的编码
  "publishTime": "2020-03-25 00:00:00", // 发行时间
  "audioUrl": "http://xxx/2.mp3", // 音频链接
  "company": "KnowYourself", // 传输方名
  "albumNumber": "rdxxx", // 传输方用于唯一标识的书籍编码
  "transName": "", // 单集翻译名
  "otherName": "", // 单集其他名
  "saleTime": "0000-00-00 00:00:00", // 上线时间(为 0000-00-00 00:00:00 表示不自动上线)
  "audioChange": 0 // 更新音频(如果希望更新音频，则置为 1)
}
```
