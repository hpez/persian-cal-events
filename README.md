# Persian Calendar Events [![codecov](https://codecov.io/gh/hpez/persian-cal-events/branch/master/graph/badge.svg)](https://codecov.io/gh/hpez/persian-cal-events) [![Build Status](https://travis-ci.org/hpez/persian-cal-events.svg?branch=master)](https://travis-ci.org/hpez/persian-cal-events)

This package aims to provide events for Persian calendar (jalali) crawling time.ir and using [morilog/jalali](https://github.com/morilog/jalali) for conversion.

## Features

* Indicates holidays
* Events in that day
* Supports both jalali and gregorian
* Indicates if an event is due to religious reasons

## Installation
    composer require hpez/persian-cal-event

## Usage
    PersianCalEvent::jalali(1398, 1, 1);
    /*
    {
        "is_holiday": true,
        "events": [
            {
                "description": "جشن نوروز/جشن سال نو",
                "additional_description": "",
                "is_religious": false
            }
        ]
    } 
    */
    
    PersianCalEvent::gregorian(2019, 8, 12);
    PersianCalEvent::gregorian(new Carbon('2019-08-12'));
    /*
    {
        "is_holiday": true,
        "events": [
            {
                "description": "عید سعید قربان",
                "additional_description": "١٠ ذوالحجه",
                "is_religious": true
            }
        ]
    }
    */
 


