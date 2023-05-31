---
code: null
id: I_kwDOGkiayc5JGj__
databaseId: 1226457087
number: 6
url: https://github.com/octolab/observer/issues/6
title: "implement event bus with breaker"
issueType: null
labels: []
assignees:
  - kamilsk
milestone: null
parent: null
issueFields: {}
state: OPEN
stateReason: null
duplicateOf: null
createdAt: 2022-05-05T09:57:39Z
updatedAt: 2022-05-05T09:57:40Z
lastEditedAt: null
closedAt: null
---

# implement event bus with breaker

- describe interface
- describe guards

draft

```php
interface Eventer {
  Subscribe(Event, Subscriber)
}
# or
interface Subscriber {
  Listen(Event, Listener)
}

interface Listener {
  Handle(Event, Subscriber, depth = 0)
}
```
