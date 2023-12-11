# tag-stats


#### Запуск

```
sudo ./start.sh
```

#### Запросы

1) Получить статистику
```
{
    "query": "query {getTagsStat ( getStatsInput: {startDate: \"2021-04-01 23:01:00\", endDate: \"2025-04-01 23:01:02\", type: \"FIRST\"})}"
}
```
2) Создать тег 
```
{
    "query": "mutation {createTag ( createTagInput: {name: \"testName\", color: \"red\", type: \"FIRST\" score: 78})}"
}
```

3) Обновить тег
```
{
    "query": "mutation {updateTag (uuid: \"761a311f-e427-4901-95f3-75ce934a08d7\", color: \"red\")}"
}
```
