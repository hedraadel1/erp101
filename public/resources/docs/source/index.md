---
title: API Reference

language_tabs:
- bash
- javascript

includes:

search: true

toc_footers:
- <a href='http://github.com/mpociot/documentarian'>Documentation Powered by Documentarian</a>
---
<!-- START_INFO -->
# Info

Welcome to the generated API reference.
[Get Postman Collection](http://www.gyral.link/erpnew/public/docs/collection.json)

<!-- END_INFO -->

#CRM


<!-- START_769942ab71bff81917e9ac7df7b234d8 -->
## List Follow ups

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET \
    -G "http://www.gyral.link/erpnew/public/connector/api/crm/follow-ups?start_date=2020-12-16&end_date=2020-12-16&status=pariatur&follow_up_type=reiciendis&order_by=start_datetime&direction=desc&per_page=10" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: Bearer {token}"
```

```javascript
const url = new URL(
    "http://www.gyral.link/erpnew/public/connector/api/crm/follow-ups"
);

let params = {
    "start_date": "2020-12-16",
    "end_date": "2020-12-16",
    "status": "pariatur",
    "follow_up_type": "reiciendis",
    "order_by": "start_datetime",
    "direction": "desc",
    "per_page": "10",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Authorization": "Bearer {token}",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "data": [
        {
            "id": 1,
            "business_id": 1,
            "contact_id": 50,
            "title": "Test Follow up",
            "status": "scheduled",
            "start_datetime": "2020-12-16 15:15:00",
            "end_datetime": "2020-12-16 15:15:00",
            "description": "<p>tst<\/p>",
            "schedule_type": "call",
            "allow_notification": 0,
            "notify_via": {
                "sms": 0,
                "mail": 1
            },
            "notify_before": null,
            "notify_type": "minute",
            "created_by": 1,
            "followup_additional_info": null,
            "created_at": "2020-12-16 03:15:23",
            "updated_at": "2020-12-16 15:46:34",
            "customer": {
                "id": 50,
                "business_id": 1,
                "type": "lead",
                "supplier_business_name": null,
                "name": " Lead 4  ",
                "prefix": null,
                "first_name": "Lead 4",
                "middle_name": null,
                "last_name": null,
                "email": null,
                "contact_id": "CO0011",
                "contact_status": "active",
                "tax_number": null,
                "city": null,
                "state": null,
                "country": null,
                "address_line_1": null,
                "address_line_2": null,
                "zip_code": null,
                "dob": null,
                "mobile": "234567",
                "landline": null,
                "alternate_number": null,
                "pay_term_number": null,
                "pay_term_type": null,
                "credit_limit": null,
                "created_by": 1,
                "balance": "0.0000",
                "total_rp": 0,
                "total_rp_used": 0,
                "total_rp_expired": 0,
                "is_default": 0,
                "shipping_address": null,
                "position": null,
                "customer_group_id": null,
                "crm_source": "55",
                "crm_life_stage": "62",
                "custom_field1": null,
                "custom_field2": null,
                "custom_field3": null,
                "custom_field4": null,
                "custom_field5": null,
                "custom_field6": null,
                "custom_field7": null,
                "custom_field8": null,
                "custom_field9": null,
                "custom_field10": null,
                "deleted_at": null,
                "created_at": "2020-12-15 23:14:48",
                "updated_at": "2021-01-07 15:32:52",
                "remember_token": null,
                "password": null
            }
        },
        {
            "id": 2,
            "business_id": 1,
            "contact_id": 50,
            "title": "Test Follow up 1",
            "status": "completed",
            "start_datetime": "2020-12-16 15:46:00",
            "end_datetime": "2020-12-16 15:46:00",
            "description": "<p>Test Follow up<\/p>",
            "schedule_type": "call",
            "allow_notification": 0,
            "notify_via": {
                "sms": 0,
                "mail": 1
            },
            "notify_before": null,
            "notify_type": "minute",
            "created_by": 1,
            "followup_additional_info": null,
            "created_at": "2020-12-16 15:46:57",
            "updated_at": "2020-12-17 10:24:11",
            "customer": {
                "id": 50,
                "business_id": 1,
                "type": "lead",
                "supplier_business_name": null,
                "name": " Lead 4  ",
                "prefix": null,
                "first_name": "Lead 4",
                "middle_name": null,
                "last_name": null,
                "email": null,
                "contact_id": "CO0011",
                "contact_status": "active",
                "tax_number": null,
                "city": null,
                "state": null,
                "country": null,
                "address_line_1": null,
                "address_line_2": null,
                "zip_code": null,
                "dob": null,
                "mobile": "234567",
                "landline": null,
                "alternate_number": null,
                "pay_term_number": null,
                "pay_term_type": null,
                "credit_limit": null,
                "created_by": 1,
                "balance": "0.0000",
                "total_rp": 0,
                "total_rp_used": 0,
                "total_rp_expired": 0,
                "is_default": 0,
                "shipping_address": null,
                "position": null,
                "customer_group_id": null,
                "crm_source": "55",
                "crm_life_stage": "62",
                "custom_field1": null,
                "custom_field2": null,
                "custom_field3": null,
                "custom_field4": null,
                "custom_field5": null,
                "custom_field6": null,
                "custom_field7": null,
                "custom_field8": null,
                "custom_field9": null,
                "custom_field10": null,
                "deleted_at": null,
                "created_at": "2020-12-15 23:14:48",
                "updated_at": "2021-01-07 15:32:52",
                "remember_token": null,
                "password": null
            }
        }
    ],
    "links": {
        "first": "http:\/\/local.pos.com\/connector\/api\/crm\/follow-ups?page=1",
        "last": "http:\/\/local.pos.com\/connector\/api\/crm\/follow-ups?page=21",
        "prev": null,
        "next": "http:\/\/local.pos.com\/connector\/api\/crm\/follow-ups?page=2"
    },
    "meta": {
        "current_page": 1,
        "from": 1,
        "last_page": 21,
        "path": "http:\/\/local.pos.com\/connector\/api\/crm\/follow-ups",
        "per_page": "2",
        "to": 2,
        "total": 42
    }
}
```

### HTTP Request
`GET connector/api/crm/follow-ups`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `start_date` |  optional  | format: Y-m-d (Ex: 2020-12-16)
    `end_date` |  optional  | format: Y-m-d (Ex: 2020-12-16)
    `status` |  optional  | filter the result through status, get status from getFollowUpResources->statuses
    `follow_up_type` |  optional  | filter the result through follow_up_type, get follow_up_type from getFollowUpResources->follow_up_types
    `order_by` |  optional  | Column name to sort the result, Column: start_datetime
    `direction` |  optional  | Direction to sort the result, Required if using 'order_by', direction: desc, asc
    `per_page` |  optional  | Total records per page. default: 10, Set -1 for no pagination

<!-- END_769942ab71bff81917e9ac7df7b234d8 -->

<!-- START_bd9693a0666e19abef8cc5b2a6ef4c9a -->
## Add follow up

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST \
    "http://www.gyral.link/erpnew/public/connector/api/crm/follow-ups" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: Bearer {token}" \
    -d '{"title":"Meeting with client","contact_id":2,"description":"laboriosam","schedule_type":"molestiae","user_id":"[2,3,5]","notify_before":5,"notify_type":"minute","status":"open","notify_via":"['sms' => 0 ,'mail' => 1]","start_datetime":"2021-01-06 13:05:00","end_datetime":"2021-01-06 13:05:00","followup_additional_info":"['call duration' => '1 hour']","allow_notification":true}'

```

```javascript
const url = new URL(
    "http://www.gyral.link/erpnew/public/connector/api/crm/follow-ups"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Authorization": "Bearer {token}",
};

let body = {
    "title": "Meeting with client",
    "contact_id": 2,
    "description": "laboriosam",
    "schedule_type": "molestiae",
    "user_id": "[2,3,5]",
    "notify_before": 5,
    "notify_type": "minute",
    "status": "open",
    "notify_via": "['sms' => 0 ,'mail' => 1]",
    "start_datetime": "2021-01-06 13:05:00",
    "end_datetime": "2021-01-06 13:05:00",
    "followup_additional_info": "['call duration' => '1 hour']",
    "allow_notification": true
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "data": {
        "title": "test",
        "contact_id": "1",
        "description": null,
        "schedule_type": "call",
        "notify_before": null,
        "status": null,
        "start_datetime": "2021-01-06 15:27:00",
        "end_datetime": "2021-01-06 15:27:00",
        "allow_notification": 0,
        "notify_via": {
            "sms": 1,
            "mail": 1
        },
        "notify_type": "hour",
        "business_id": 1,
        "created_by": 1,
        "updated_at": "2021-01-06 17:04:54",
        "created_at": "2021-01-06 17:04:54",
        "id": 20
    }
}
```

### HTTP Request
`POST connector/api/crm/follow-ups`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `title` | string |  required  | Follow up title
        `contact_id` | integer |  required  | Contact to be followed up
        `description` | text |  optional  | Follow up description
        `schedule_type` | string |  required  | Follow up type default get from getFollowUpResources->follow_up_types
        `user_id` | array |  required  | Integer ID; Follow up to be assigned Ex: [2,3,8]
        `notify_before` | integer |  optional  | Integer value will be used to send auto notification before follow up starts.
        `notify_type` | string |  optional  | Notify type Ex: 'minute', 'hour', 'day'. default is hour
        `status` | string |  optional  | Follow up status
        `notify_via` | array |  optional  | Will be used to send notification Ex: ['sms' => 0 ,'mail' => 1]
        `start_datetime` | datetime |  required  | Follow up start datetime format: Y-m-d H:i:s Ex: 2020-12-16 03:15:23
        `end_datetime` | datetime |  required  | Follow up end datetime format: Y-m-d H:i:s Ex: 2020-12-16 03:15:23
        `followup_additional_info` | array |  optional  | Follow up additional info Ex: ['call duration' => '1 hour']
        `allow_notification` | boolean |  optional  | 0/1 : If notification will be send before follow up starts. default is 1(true)
    
<!-- END_bd9693a0666e19abef8cc5b2a6ef4c9a -->

<!-- START_a0bd3915b449b6f8282908c9b166ce42 -->
## Get the specified followup

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET \
    -G "http://www.gyral.link/erpnew/public/connector/api/crm/follow-ups/1,2" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: Bearer {token}"
```

```javascript
const url = new URL(
    "http://www.gyral.link/erpnew/public/connector/api/crm/follow-ups/1,2"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Authorization": "Bearer {token}",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "data": [
        {
            "id": 20,
            "business_id": 1,
            "contact_id": 1,
            "title": "Meeting with client",
            "status": null,
            "start_datetime": "2021-01-06 15:27:00",
            "end_datetime": "2021-01-06 15:27:00",
            "description": null,
            "schedule_type": "call",
            "allow_notification": 0,
            "notify_via": {
                "sms": 1,
                "mail": 1
            },
            "notify_before": null,
            "notify_type": "hour",
            "created_by": 1,
            "created_at": "2021-01-06 17:04:54",
            "updated_at": "2021-01-06 17:04:54",
            "customer": {
                "id": 1,
                "business_id": 1,
                "type": "customer",
                "supplier_business_name": null,
                "name": "Walk-In Customer",
                "prefix": null,
                "first_name": "Walk-In Customer",
                "middle_name": null,
                "last_name": null,
                "email": null,
                "contact_id": "CO0005",
                "contact_status": "active",
                "tax_number": null,
                "city": "Phoenix",
                "state": "Arizona",
                "country": "USA",
                "address_line_1": "Linking Street",
                "address_line_2": null,
                "zip_code": null,
                "dob": null,
                "mobile": "(378) 400-1234",
                "landline": null,
                "alternate_number": null,
                "pay_term_number": null,
                "pay_term_type": null,
                "credit_limit": null,
                "created_by": 1,
                "balance": "0.0000",
                "total_rp": 0,
                "total_rp_used": 0,
                "total_rp_expired": 0,
                "is_default": 1,
                "shipping_address": null,
                "position": null,
                "customer_group_id": null,
                "crm_source": null,
                "crm_life_stage": null,
                "custom_field1": null,
                "custom_field2": null,
                "custom_field3": null,
                "custom_field4": null,
                "custom_field5": null,
                "custom_field6": null,
                "custom_field7": null,
                "custom_field8": null,
                "custom_field9": null,
                "custom_field10": null,
                "deleted_at": null,
                "created_at": "2018-01-03 20:45:20",
                "updated_at": "2018-06-11 22:22:05",
                "remember_token": null,
                "password": null
            },
            "users": [
                {
                    "id": 2,
                    "user_type": "user",
                    "surname": "Mr",
                    "first_name": "Demo",
                    "last_name": "Cashier",
                    "username": "cashier",
                    "email": "cashier@example.com",
                    "language": "en",
                    "contact_no": null,
                    "address": null,
                    "business_id": 1,
                    "max_sales_discount_percent": null,
                    "allow_login": 1,
                    "essentials_department_id": null,
                    "essentials_designation_id": null,
                    "status": "active",
                    "crm_contact_id": null,
                    "is_cmmsn_agnt": 0,
                    "cmmsn_percent": "0.00",
                    "selected_contacts": 0,
                    "dob": null,
                    "gender": null,
                    "marital_status": null,
                    "blood_group": null,
                    "contact_number": null,
                    "fb_link": null,
                    "twitter_link": null,
                    "social_media_1": null,
                    "social_media_2": null,
                    "permanent_address": null,
                    "current_address": null,
                    "guardian_name": null,
                    "custom_field_1": null,
                    "custom_field_2": null,
                    "custom_field_3": null,
                    "custom_field_4": null,
                    "bank_details": null,
                    "id_proof_name": null,
                    "id_proof_number": null,
                    "deleted_at": null,
                    "created_at": "2018-01-04 02:20:58",
                    "updated_at": "2018-01-04 02:20:58",
                    "pivot": {
                        "schedule_id": 20,
                        "user_id": 2
                    }
                }
            ]
        }
    ]
}
```

### HTTP Request
`GET connector/api/crm/follow-ups/{follow_up}`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `follow_up` |  required  | comma separated ids of the follow_ups

<!-- END_a0bd3915b449b6f8282908c9b166ce42 -->

<!-- START_7088929a24a9e343737f77f8c947a410 -->
## Update follow up

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X PUT \
    "http://www.gyral.link/erpnew/public/connector/api/crm/follow-ups/20" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: Bearer {token}" \
    -d '{"title":"Meeting with client","contact_id":2,"description":"mollitia","schedule_type":"voluptatem","user_id":"[2,3,5]","notify_before":5,"notify_type":"minute","status":"open","notify_via":"['sms' => 0 ,'mail' => 1]","followup_additional_info":"['call duration' => '1 hour']","start_datetime":"2021-01-06 13:05:00","end_datetime":"2021-01-06 13:05:00","allow_notification":true}'

```

```javascript
const url = new URL(
    "http://www.gyral.link/erpnew/public/connector/api/crm/follow-ups/20"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Authorization": "Bearer {token}",
};

let body = {
    "title": "Meeting with client",
    "contact_id": 2,
    "description": "mollitia",
    "schedule_type": "voluptatem",
    "user_id": "[2,3,5]",
    "notify_before": 5,
    "notify_type": "minute",
    "status": "open",
    "notify_via": "['sms' => 0 ,'mail' => 1]",
    "followup_additional_info": "['call duration' => '1 hour']",
    "start_datetime": "2021-01-06 13:05:00",
    "end_datetime": "2021-01-06 13:05:00",
    "allow_notification": true
}

fetch(url, {
    method: "PUT",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "data": {
        "id": 20,
        "business_id": 1,
        "contact_id": "1",
        "title": "Meeting with client",
        "status": null,
        "start_datetime": "2021-01-06 15:27:00",
        "end_datetime": "2021-01-06 15:27:00",
        "description": null,
        "schedule_type": "call",
        "allow_notification": 0,
        "notify_via": {
            "sms": 1,
            "mail": 0
        },
        "notify_before": null,
        "notify_type": "hour",
        "created_by": 1,
        "created_at": "2021-01-06 17:04:54",
        "updated_at": "2021-01-06 18:22:21"
    }
}
```

### HTTP Request
`PUT connector/api/crm/follow-ups/{follow_up}`

`PATCH connector/api/crm/follow-ups/{follow_up}`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `follow_up` |  required  | id of the follow up to be updated
#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `title` | string |  required  | Follow up title
        `contact_id` | integer |  required  | Contact to be followed up
        `description` | text |  optional  | Follow up description
        `schedule_type` | string |  required  | Follow up type default get from getFollowUpResources->follow_up_types
        `user_id` | array |  required  | Integer ID; Follow up to be assigned Ex: [2,3,8]
        `notify_before` | integer |  optional  | Integer value will be used to send auto notification before follow up starts.
        `notify_type` | string |  optional  | Notify type Ex: 'minute', 'hour', 'day'. default is hour
        `status` | string |  optional  | Follow up status
        `notify_via` | array |  optional  | Will be used to send notification Ex: ['sms' => 0 ,'mail' => 1]
        `followup_additional_info` | array |  optional  | Follow up additional info Ex: ['call duration' => '1 hour']
        `start_datetime` | datetime |  required  | Follow up start datetime format: Y-m-d H:i:s Ex: 2020-12-16 03:15:23
        `end_datetime` | datetime |  required  | Follow up end datetime format: Y-m-d H:i:s Ex: 2020-12-16 03:15:23
        `allow_notification` | boolean |  optional  | 0/1 : If notification will be send before follow up starts. default is 1(true)
    
<!-- END_7088929a24a9e343737f77f8c947a410 -->

<!-- START_1f14240a2d5b4c33d8c3659050d659c6 -->
## Get follow up resources

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET \
    -G "http://www.gyral.link/erpnew/public/connector/api/crm/follow-up-resources" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: Bearer {token}"
```

```javascript
const url = new URL(
    "http://www.gyral.link/erpnew/public/connector/api/crm/follow-up-resources"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Authorization": "Bearer {token}",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "data": {
        "statuses": {
            "scheduled": "Scheduled",
            "open": "Open",
            "canceled": "Cancelled",
            "completed": "Completed"
        },
        "follow_up_types": {
            "call": "Call",
            "sms": "Sms",
            "meeting": "Meeting",
            "email": "Email"
        },
        "notify_type": {
            "minute": "Minute",
            "hour": "Hour",
            "day": "Day"
        },
        "notify_via": {
            "sms": "Sms",
            "mail": "Email"
        }
    }
}
```

### HTTP Request
`GET connector/api/crm/follow-up-resources`


<!-- END_1f14240a2d5b4c33d8c3659050d659c6 -->

<!-- START_1130c94d8503bf4189f9b516f11714b8 -->
## List lead

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET \
    -G "http://www.gyral.link/erpnew/public/connector/api/crm/leads?assigned_to=1%2C2%2C3&name=excepturi&biz_name=eveniet&mobile_num=20&contact_id=facilis&order_by=repellat&direction=desc&per_page=10" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: Bearer {token}"
```

```javascript
const url = new URL(
    "http://www.gyral.link/erpnew/public/connector/api/crm/leads"
);

let params = {
    "assigned_to": "1,2,3",
    "name": "excepturi",
    "biz_name": "eveniet",
    "mobile_num": "20",
    "contact_id": "facilis",
    "order_by": "repellat",
    "direction": "desc",
    "per_page": "10",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Authorization": "Bearer {token}",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "data": [
        {
            "contact_id": "CO0010",
            "name": "mr Lead 3 kr kr 2",
            "supplier_business_name": "POS",
            "email": null,
            "mobile": "9437638555",
            "tax_number": null,
            "created_at": "2020-12-15 23:14:30",
            "custom_field1": null,
            "custom_field2": null,
            "custom_field3": null,
            "custom_field4": null,
            "custom_field5": null,
            "custom_field6": null,
            "alternate_number": null,
            "landline": null,
            "dob": null,
            "contact_status": "active",
            "type": "lead",
            "custom_field7": null,
            "custom_field8": null,
            "custom_field9": null,
            "custom_field10": null,
            "id": 49,
            "business_id": 1,
            "crm_source": "55",
            "crm_life_stage": "60",
            "address_line_1": null,
            "address_line_2": null,
            "city": null,
            "state": null,
            "country": null,
            "zip_code": null,
            "last_follow_up_id": 18,
            "upcoming_follow_up_id": null,
            "last_follow_up": "2021-01-07 10:26:00",
            "upcoming_follow_up": null,
            "last_follow_up_additional_info": "{\"test\":\"test done\",\"call_duration\":\"1.5 Hour\",\"rand\":1}",
            "upcoming_follow_up_additional_info": null,
            "source": {
                "id": 55,
                "name": "Facebook",
                "business_id": 1,
                "short_code": null,
                "parent_id": 0,
                "created_by": 1,
                "category_type": "source",
                "description": "Facebook",
                "slug": null,
                "woocommerce_cat_id": null,
                "deleted_at": null,
                "created_at": "2020-12-15 23:07:53",
                "updated_at": "2020-12-15 23:07:53"
            },
            "life_stage": {
                "id": 60,
                "name": "Open Deal",
                "business_id": 1,
                "short_code": null,
                "parent_id": 0,
                "created_by": 1,
                "category_type": "life_stage",
                "description": "Open Deal",
                "slug": null,
                "woocommerce_cat_id": null,
                "deleted_at": null,
                "created_at": "2020-12-15 23:11:05",
                "updated_at": "2020-12-15 23:11:05"
            },
            "lead_users": [
                {
                    "id": 10,
                    "user_type": "user",
                    "surname": "Mr.",
                    "first_name": "WooCommerce",
                    "last_name": "User",
                    "username": "woocommerce_user",
                    "email": "woo@example.com",
                    "language": "en",
                    "contact_no": null,
                    "address": null,
                    "business_id": 1,
                    "max_sales_discount_percent": null,
                    "allow_login": 1,
                    "essentials_department_id": null,
                    "essentials_designation_id": null,
                    "status": "active",
                    "crm_contact_id": null,
                    "is_cmmsn_agnt": 0,
                    "cmmsn_percent": "0.00",
                    "selected_contacts": 0,
                    "dob": null,
                    "gender": null,
                    "marital_status": null,
                    "blood_group": null,
                    "contact_number": null,
                    "fb_link": null,
                    "twitter_link": null,
                    "social_media_1": null,
                    "social_media_2": null,
                    "permanent_address": null,
                    "current_address": null,
                    "guardian_name": null,
                    "custom_field_1": null,
                    "custom_field_2": null,
                    "custom_field_3": null,
                    "custom_field_4": null,
                    "bank_details": null,
                    "id_proof_name": null,
                    "id_proof_number": null,
                    "deleted_at": null,
                    "created_at": "2018-08-02 04:05:55",
                    "updated_at": "2018-08-02 04:05:55",
                    "pivot": {
                        "contact_id": 49,
                        "user_id": 10
                    }
                }
            ]
        },
        {
            "contact_id": "CO0011",
            "name": " Lead 4  ",
            "supplier_business_name": null,
            "email": null,
            "mobile": "234567",
            "tax_number": null,
            "created_at": "2020-12-15 23:14:48",
            "custom_field1": null,
            "custom_field2": null,
            "custom_field3": null,
            "custom_field4": null,
            "custom_field5": null,
            "custom_field6": null,
            "alternate_number": null,
            "landline": null,
            "dob": null,
            "contact_status": "active",
            "type": "lead",
            "custom_field7": null,
            "custom_field8": null,
            "custom_field9": null,
            "custom_field10": null,
            "id": 50,
            "business_id": 1,
            "crm_source": "55",
            "crm_life_stage": "62",
            "address_line_1": null,
            "address_line_2": null,
            "city": null,
            "state": null,
            "country": null,
            "zip_code": null,
            "last_follow_up_id": 32,
            "upcoming_follow_up_id": null,
            "last_follow_up": "2021-01-08 16:06:00",
            "upcoming_follow_up": null,
            "last_follow_up_additional_info": "{\"call_durartion\":\"5 hour\"}",
            "upcoming_follow_up_additional_info": null,
            "source": {
                "id": 55,
                "name": "Facebook",
                "business_id": 1,
                "short_code": null,
                "parent_id": 0,
                "created_by": 1,
                "category_type": "source",
                "description": "Facebook",
                "slug": null,
                "woocommerce_cat_id": null,
                "deleted_at": null,
                "created_at": "2020-12-15 23:07:53",
                "updated_at": "2020-12-15 23:07:53"
            },
            "life_stage": {
                "id": 62,
                "name": "New",
                "business_id": 1,
                "short_code": null,
                "parent_id": 0,
                "created_by": 1,
                "category_type": "life_stage",
                "description": "New",
                "slug": null,
                "woocommerce_cat_id": null,
                "deleted_at": null,
                "created_at": "2020-12-15 23:11:26",
                "updated_at": "2020-12-15 23:11:26"
            },
            "lead_users": [
                {
                    "id": 11,
                    "user_type": "user",
                    "surname": "Mr",
                    "first_name": "Admin Essential",
                    "last_name": null,
                    "username": "admin-essentials",
                    "email": "admin_essentials@example.com",
                    "language": "en",
                    "contact_no": null,
                    "address": null,
                    "business_id": 1,
                    "max_sales_discount_percent": null,
                    "allow_login": 1,
                    "essentials_department_id": null,
                    "essentials_designation_id": null,
                    "status": "active",
                    "crm_contact_id": null,
                    "is_cmmsn_agnt": 0,
                    "cmmsn_percent": "0.00",
                    "selected_contacts": 0,
                    "dob": null,
                    "gender": null,
                    "marital_status": null,
                    "blood_group": null,
                    "contact_number": null,
                    "fb_link": null,
                    "twitter_link": null,
                    "social_media_1": null,
                    "social_media_2": null,
                    "permanent_address": null,
                    "current_address": null,
                    "guardian_name": null,
                    "custom_field_1": null,
                    "custom_field_2": null,
                    "custom_field_3": null,
                    "custom_field_4": null,
                    "bank_details": null,
                    "id_proof_name": null,
                    "id_proof_number": null,
                    "deleted_at": null,
                    "created_at": "2018-01-04 02:15:19",
                    "updated_at": "2018-01-04 02:15:19",
                    "pivot": {
                        "contact_id": 50,
                        "user_id": 11
                    }
                }
            ]
        },
        {
            "contact_id": "CO0015",
            "name": " Lead kr  ",
            "supplier_business_name": null,
            "email": null,
            "mobile": "9437638555",
            "tax_number": null,
            "created_at": "2021-01-07 18:31:08",
            "custom_field1": null,
            "custom_field2": null,
            "custom_field3": null,
            "custom_field4": null,
            "custom_field5": null,
            "custom_field6": null,
            "alternate_number": null,
            "landline": null,
            "dob": "2021-01-07",
            "contact_status": "active",
            "type": "lead",
            "custom_field7": null,
            "custom_field8": null,
            "custom_field9": null,
            "custom_field10": null,
            "id": 82,
            "business_id": 1,
            "crm_source": null,
            "crm_life_stage": null,
            "address_line_1": null,
            "address_line_2": null,
            "city": null,
            "state": null,
            "country": null,
            "zip_code": null,
            "last_follow_up_id": 36,
            "upcoming_follow_up_id": null,
            "last_follow_up": "2021-01-07 18:31:08",
            "upcoming_follow_up": null,
            "last_follow_up_additional_info": "{\"call duration\":\"1 hour\",\"call descr\":\"talked to him and all okay\"}",
            "upcoming_follow_up_additional_info": null,
            "source": null,
            "life_stage": null,
            "lead_users": [
                {
                    "id": 11,
                    "user_type": "user",
                    "surname": "Mr",
                    "first_name": "Admin Essential",
                    "last_name": null,
                    "username": "admin-essentials",
                    "email": "admin_essentials@example.com",
                    "language": "en",
                    "contact_no": null,
                    "address": null,
                    "business_id": 1,
                    "max_sales_discount_percent": null,
                    "allow_login": 1,
                    "essentials_department_id": null,
                    "essentials_designation_id": null,
                    "status": "active",
                    "crm_contact_id": null,
                    "is_cmmsn_agnt": 0,
                    "cmmsn_percent": "0.00",
                    "selected_contacts": 0,
                    "dob": null,
                    "gender": null,
                    "marital_status": null,
                    "blood_group": null,
                    "contact_number": null,
                    "fb_link": null,
                    "twitter_link": null,
                    "social_media_1": null,
                    "social_media_2": null,
                    "permanent_address": null,
                    "current_address": null,
                    "guardian_name": null,
                    "custom_field_1": null,
                    "custom_field_2": null,
                    "custom_field_3": null,
                    "custom_field_4": null,
                    "bank_details": null,
                    "id_proof_name": null,
                    "id_proof_number": null,
                    "deleted_at": null,
                    "created_at": "2018-01-04 02:15:19",
                    "updated_at": "2018-01-04 02:15:19",
                    "pivot": {
                        "contact_id": 82,
                        "user_id": 11
                    }
                }
            ]
        }
    ],
    "links": {
        "first": "http:\/\/local.pos.com\/connector\/api\/crm\/leads?page=1",
        "last": "http:\/\/local.pos.com\/connector\/api\/crm\/leads?page=1",
        "prev": null,
        "next": null
    },
    "meta": {
        "current_page": 1,
        "from": 1,
        "last_page": 1,
        "path": "http:\/\/local.pos.com\/connector\/api\/crm\/leads",
        "per_page": "10",
        "to": 3,
        "total": 3
    }
}
```

### HTTP Request
`GET connector/api/crm/leads`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `assigned_to` |  optional  | comma separated ids of users to whom lead is assigned (Ex: 1,2,3)
    `name` |  optional  | Search term for lead name
    `biz_name` |  optional  | Search term for lead's business name
    `mobile_num` |  optional  | Search term for lead's mobile number
    `contact_id` |  optional  | Search term for lead's contact_id. Ex(CO0005)
    `order_by` |  optional  | Column name to sort the result, Column: name, supplier_business_name
    `direction` |  optional  | Direction to sort the result, Required if using 'order_by', direction: desc, asc
    `per_page` |  optional  | Total records per page. default: 10, Set -1 for no pagination

<!-- END_1130c94d8503bf4189f9b516f11714b8 -->

<!-- START_da92fa7a02594a4309d0ad9614b1bc1b -->
## Save Call Logs

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST \
    "http://www.gyral.link/erpnew/public/connector/api/crm/call-logs" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: Bearer {token}" \
    -d '{"call_logs":[{"mobile_number":"totam","mobile_name":"esse","call_type":"call","start_time":"mollitia","end_time":"aut","duration":"et"}]}'

```

```javascript
const url = new URL(
    "http://www.gyral.link/erpnew/public/connector/api/crm/call-logs"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Authorization": "Bearer {token}",
};

let body = {
    "call_logs": [
        {
            "mobile_number": "totam",
            "mobile_name": "esse",
            "call_type": "call",
            "start_time": "mollitia",
            "end_time": "aut",
            "duration": "et"
        }
    ]
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST connector/api/crm/call-logs`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `call_logs.*.mobile_number` | string |  required  | Mobile number of the customer or user
        `call_logs.*.mobile_name` | string |  optional  | Name of the contact saved in the mobile
        `call_logs.*.call_type` | string |  optional  | Call type (call, sms)
        `call_logs.*.start_time` | string |  optional  | Start datetime of the call in "Y-m-d H:i:s" format
        `call_logs.*.end_time` | string |  optional  | End datetime of the call in "Y-m-d H:i:s" format
        `call_logs.*.duration` | string |  optional  | Duration of the call in seconds
    
<!-- END_da92fa7a02594a4309d0ad9614b1bc1b -->

#Field Force


<!-- START_9ae4136ebb8f477c34d68f47332f9652 -->
## List visits

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET \
    -G "http://www.gyral.link/erpnew/public/connector/api/field-force?contact_id=ut&assigned_to=aut&status=dolorem&start_date=2018-06-25&end_date=2018-06-25&per_page=15&order_by_date=desc" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: Bearer {token}"
```

```javascript
const url = new URL(
    "http://www.gyral.link/erpnew/public/connector/api/field-force"
);

let params = {
    "contact_id": "ut",
    "assigned_to": "aut",
    "status": "dolorem",
    "start_date": "2018-06-25",
    "end_date": "2018-06-25",
    "per_page": "15",
    "order_by_date": "desc",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Authorization": "Bearer {token}",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (401):

```json
{
    "error": "Unauthenticated."
}
```

### HTTP Request
`GET connector/api/field-force`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `contact_id` |  optional  | id of the contact
    `assigned_to` |  optional  | id of the assigned user
    `status` |  optional  | status of the visit (assigned, finished)
    `start_date` |  optional  | Start date filter for visit on format:Y-m-d
    `end_date` |  optional  | End date filter for visit on format:Y-m-d
    `per_page` |  optional  | Total records per page. default: 10, Set -1 for no pagination
    `order_by_date` |  optional  | Sort visit by visit on date ('asc', 'desc')

<!-- END_9ae4136ebb8f477c34d68f47332f9652 -->

<!-- START_b2acfbbc6dfe76d2bc7331dad7e9d96c -->
## Create Visit

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST \
    "http://www.gyral.link/erpnew/public/connector/api/field-force/create" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: Bearer {token}" \
    -d '{"contact_id":3,"visit_to":"magni","visit_address":"temporibus","assigned_to":4,"visit_on":"2021-12-28 17:23:00","visit_for":"laboriosam"}'

```

```javascript
const url = new URL(
    "http://www.gyral.link/erpnew/public/connector/api/field-force/create"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Authorization": "Bearer {token}",
};

let body = {
    "contact_id": 3,
    "visit_to": "magni",
    "visit_address": "temporibus",
    "assigned_to": 4,
    "visit_on": "2021-12-28 17:23:00",
    "visit_for": "laboriosam"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "data": {
        "contact_id": "6",
        "assigned_to": "9",
        "visit_on": "2022-01-15 17:23:00",
        "visit_for": "",
        "visit_id": "2021\/0031",
        "status": "assigned",
        "business_id": 1,
        "updated_at": "2021-12-30 11:00:47",
        "created_at": "2021-12-30 11:00:47",
        "id": 3
    }
}
```

### HTTP Request
`POST connector/api/field-force/create`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `contact_id` | integer |  optional  | id of the contact
        `visit_to` | string |  optional  | Name of the visiting person or company if contact_id is not given
        `visit_address` | string |  optional  | Address of the visiting person or company if contact_id is not given
        `assigned_to` | integer |  required  | id of the assigned user
        `visit_on` | format:Y-m-d |  optional  | H:i:s
        `visit_for` | string |  optional  | Purpose of visiting
    
<!-- END_b2acfbbc6dfe76d2bc7331dad7e9d96c -->

<!-- START_0858d78abd7219edaf878fac4fb38d13 -->
## Update Visit status

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST \
    "http://www.gyral.link/erpnew/public/connector/api/field-force/update-visit-status/17" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: Bearer {token}" \
    -d '{"status":"finished","reason_to_not_meet_contact":"sed","visited_on":"2021-12-28 17:23:00","visited_address":"Radhanath Mullick Ln, Tiretta Bazaar, Bow Bazaar, Kolkata, West Bengal, 700 073, India","latitude":"41.40338","longitude":"2.17403","comments":"vitae","photo":"sint"}'

```

```javascript
const url = new URL(
    "http://www.gyral.link/erpnew/public/connector/api/field-force/update-visit-status/17"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Authorization": "Bearer {token}",
};

let body = {
    "status": "finished",
    "reason_to_not_meet_contact": "sed",
    "visited_on": "2021-12-28 17:23:00",
    "visited_address": "Radhanath Mullick Ln, Tiretta Bazaar, Bow Bazaar, Kolkata, West Bengal, 700 073, India",
    "latitude": "41.40338",
    "longitude": "2.17403",
    "comments": "vitae",
    "photo": "sint"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "data": {
        "id": 10,
        "business_id": 1,
        "contact_id": 6,
        "assigned_to": 9,
        "visited_address": "New address",
        "status": "finished",
        "visit_on": "2021-12-28 17:23:00",
        "visit_for": "assigned from api",
        "comments": "Users comment",
        "created_at": "2021-12-28 17:35:13",
        "updated_at": "2021-12-28 18:06:03"
    }
}
```

### HTTP Request
`POST connector/api/field-force/update-visit-status/{id}`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `id` |  required  | id of the visit to be updated
#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `status` | string |  optional  | Current status of the visit (assigned, finished, met_contact, did_not_meet_contact)
        `reason_to_not_meet_contact` | string |  optional  | Reason if status is did_not_meet_contact
        `visited_on` | format:Y-m-d |  optional  | H:i:s
        `visited_address` | string |  optional  | Full address of the contact
        `latitude` | decimal |  optional  | Lattitude of the user location if full address is not given
        `longitude` | decimal |  optional  | Longitude of the user location if full address is not given
        `comments` | string |  optional  | Extra comments
        `photo` | file |  optional  | Upload Photo as a file of the visit if any or base64 encoded image
    
<!-- END_0858d78abd7219edaf878fac4fb38d13 -->


