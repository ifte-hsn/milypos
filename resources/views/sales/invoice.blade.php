<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>
        Sales Invoice - {{ $sale->code }}
        :: {{ ($milyPosSettings) && ($milyPosSettings->site_name) ? $milyPosSettings->site_name : 'Mily POS' }}
    </title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">


    <link rel="shortcut icon" type="image/png" href="{{ asset('images/'.$milyPosSettings->favicon) }}"/>
    <style>
        /*!
 * Bootstrap v3.3.7 (http://getbootstrap.com)
 * Copyright 2011-2019 Twitter, Inc.
 * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
 */

        /*!
         * Generated using the Bootstrap Customizer (<none>)
         * Config saved to config.json and <none>
         */
        /*!
         * Bootstrap v3.3.7 (http://getbootstrap.com)
         * Copyright 2011-2016 Twitter, Inc.
         * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
         */
        /*! normalize.css v3.0.3 | MIT License | github.com/necolas/normalize.css */
        html {
            font-family: sans-serif;
            -ms-text-size-adjust: 100%;
            -webkit-text-size-adjust: 100%;
        }
        body {
            margin: 0;
        }
        article,
        aside,
        details,
        figcaption,
        figure,
        footer,
        header,
        hgroup,
        main,
        menu,
        nav,
        section,
        summary {
            display: block;
        }
        audio,
        canvas,
        progress,
        video {
            display: inline-block;
            vertical-align: baseline;
        }
        audio:not([controls]) {
            display: none;
            height: 0;
        }
        [hidden],
        template {
            display: none;
        }
        a {
            background-color: transparent;
        }
        a:active,
        a:hover {
            outline: 0;
        }
        abbr[title] {
            border-bottom: 1px dotted;
        }
        b,
        strong {
            font-weight: bold;
        }
        dfn {
            font-style: italic;
        }
        h1 {
            font-size: 2em;
            margin: 0.67em 0;
        }
        mark {
            background: #ff0;
            color: #000;
        }
        small {
            font-size: 80%;
        }
        sub,
        sup {
            font-size: 75%;
            line-height: 0;
            position: relative;
            vertical-align: baseline;
        }
        sup {
            top: -0.5em;
        }
        sub {
            bottom: -0.25em;
        }
        img {
            border: 0;
        }
        svg:not(:root) {
            overflow: hidden;
        }
        figure {
            margin: 1em 40px;
        }
        hr {
            -webkit-box-sizing: content-box;
            -moz-box-sizing: content-box;
            box-sizing: content-box;
            height: 0;
        }
        pre {
            overflow: auto;
        }
        code,
        kbd,
        pre,
        samp {
            font-family: monospace, monospace;
            font-size: 1em;
        }
        button,
        input,
        optgroup,
        select,
        textarea {
            color: inherit;
            font: inherit;
            margin: 0;
        }
        button {
            overflow: visible;
        }
        button,
        select {
            text-transform: none;
        }
        button,
        html input[type="button"],
        input[type="reset"],
        input[type="submit"] {
            -webkit-appearance: button;
            cursor: pointer;
        }
        button[disabled],
        html input[disabled] {
            cursor: default;
        }
        button::-moz-focus-inner,
        input::-moz-focus-inner {
            border: 0;
            padding: 0;
        }
        input {
            line-height: normal;
        }
        input[type="checkbox"],
        input[type="radio"] {
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
            padding: 0;
        }
        input[type="number"]::-webkit-inner-spin-button,
        input[type="number"]::-webkit-outer-spin-button {
            height: auto;
        }
        input[type="search"] {
            -webkit-appearance: textfield;
            -webkit-box-sizing: content-box;
            -moz-box-sizing: content-box;
            box-sizing: content-box;
        }
        input[type="search"]::-webkit-search-cancel-button,
        input[type="search"]::-webkit-search-decoration {
            -webkit-appearance: none;
        }
        fieldset {
            border: 1px solid #c0c0c0;
            margin: 0 2px;
            padding: 0.35em 0.625em 0.75em;
        }
        legend {
            border: 0;
            padding: 0;
        }
        textarea {
            overflow: auto;
        }
        optgroup {
            font-weight: bold;
        }
        table {
            border-collapse: collapse;
            border-spacing: 0;
        }
        td,
        th {
            padding: 0;
        }
        /*! Source: https://github.com/h5bp/html5-boilerplate/blob/master/src/css/main.css */
        @media print {
            *,
            *:before,
            *:after {
                background: transparent !important;
                color: #000 !important;
                -webkit-box-shadow: none !important;
                box-shadow: none !important;
                text-shadow: none !important;
            }
            a,
            a:visited {
                text-decoration: underline;
            }
            a[href]:after {
                content: " (" attr(href) ")";
            }
            abbr[title]:after {
                content: " (" attr(title) ")";
            }
            a[href^="#"]:after,
            a[href^="javascript:"]:after {
                content: "";
            }
            pre,
            blockquote {
                border: 1px solid #999;
                page-break-inside: avoid;
            }
            thead {
                display: table-header-group;
            }
            tr,
            img {
                page-break-inside: avoid;
            }
            img {
                max-width: 100% !important;
            }
            p,
            h2,
            h3 {
                orphans: 3;
                widows: 3;
            }
            h2,
            h3 {
                page-break-after: avoid;
            }
            .navbar {
                display: none;
            }
            .btn > .caret,
            .dropup > .btn > .caret {
                border-top-color: #000 !important;
            }
            .label {
                border: 1px solid #000;
            }
            .table {
                border-collapse: collapse !important;
            }
            .table td,
            .table th {
                background-color: #fff !important;
            }
            .table-bordered th,
            .table-bordered td {
                border: 1px solid #ddd !important;
            }
        }
        * {
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
        }
        *:before,
        *:after {
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
        }
        html {
            font-size: 10px;
            -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
        }
        body {
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
            font-size: 14px;
            line-height: 1.42857143;
            color: #333333;
            background-color: #ffffff;
        }
        input,
        button,
        select,
        textarea {
            font-family: inherit;
            font-size: inherit;
            line-height: inherit;
        }
        a {
            color: #337ab7;
            text-decoration: none;
        }
        a:hover,
        a:focus {
            color: #23527c;
            text-decoration: underline;
        }
        a:focus {
            outline: 5px auto -webkit-focus-ring-color;
            outline-offset: -2px;
        }
        figure {
            margin: 0;
        }
        img {
            vertical-align: middle;
        }
        .img-responsive {
            display: block;
            max-width: 100%;
            height: auto;
        }
        .img-rounded {
            border-radius: 6px;
        }
        .img-thumbnail {
            padding: 4px;
            line-height: 1.42857143;
            background-color: #ffffff;
            border: 1px solid #dddddd;
            border-radius: 4px;
            -webkit-transition: all 0.2s ease-in-out;
            -o-transition: all 0.2s ease-in-out;
            transition: all 0.2s ease-in-out;
            display: inline-block;
            max-width: 100%;
            height: auto;
        }
        .img-circle {
            border-radius: 50%;
        }
        hr {
            margin-top: 20px;
            margin-bottom: 20px;
            border: 0;
            border-top: 1px solid #eeeeee;
        }
        .sr-only {
            position: absolute;
            width: 1px;
            height: 1px;
            margin: -1px;
            padding: 0;
            overflow: hidden;
            clip: rect(0, 0, 0, 0);
            border: 0;
        }
        .sr-only-focusable:active,
        .sr-only-focusable:focus {
            position: static;
            width: auto;
            height: auto;
            margin: 0;
            overflow: visible;
            clip: auto;
        }
        [role="button"] {
            cursor: pointer;
        }
        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        .h1,
        .h2,
        .h3,
        .h4,
        .h5,
        .h6 {
            font-family: inherit;
            font-weight: 500;
            line-height: 1.1;
            color: inherit;
        }
        h1 small,
        h2 small,
        h3 small,
        h4 small,
        h5 small,
        h6 small,
        .h1 small,
        .h2 small,
        .h3 small,
        .h4 small,
        .h5 small,
        .h6 small,
        h1 .small,
        h2 .small,
        h3 .small,
        h4 .small,
        h5 .small,
        h6 .small,
        .h1 .small,
        .h2 .small,
        .h3 .small,
        .h4 .small,
        .h5 .small,
        .h6 .small {
            font-weight: normal;
            line-height: 1;
            color: #777777;
        }
        h1,
        .h1,
        h2,
        .h2,
        h3,
        .h3 {
            margin-top: 20px;
            margin-bottom: 10px;
        }
        h1 small,
        .h1 small,
        h2 small,
        .h2 small,
        h3 small,
        .h3 small,
        h1 .small,
        .h1 .small,
        h2 .small,
        .h2 .small,
        h3 .small,
        .h3 .small {
            font-size: 65%;
        }
        h4,
        .h4,
        h5,
        .h5,
        h6,
        .h6 {
            margin-top: 10px;
            margin-bottom: 10px;
        }
        h4 small,
        .h4 small,
        h5 small,
        .h5 small,
        h6 small,
        .h6 small,
        h4 .small,
        .h4 .small,
        h5 .small,
        .h5 .small,
        h6 .small,
        .h6 .small {
            font-size: 75%;
        }
        h1,
        .h1 {
            font-size: 36px;
        }
        h2,
        .h2 {
            font-size: 30px;
        }
        h3,
        .h3 {
            font-size: 24px;
        }
        h4,
        .h4 {
            font-size: 18px;
        }
        h5,
        .h5 {
            font-size: 14px;
        }
        h6,
        .h6 {
            font-size: 12px;
        }
        p {
            margin: 0 0 10px;
        }
        .lead {
            margin-bottom: 20px;
            font-size: 16px;
            font-weight: 300;
            line-height: 1.4;
        }
        @media (min-width: 768px) {
            .lead {
                font-size: 21px;
            }
        }
        small,
        .small {
            font-size: 85%;
        }
        mark,
        .mark {
            background-color: #fcf8e3;
            padding: .2em;
        }
        .text-left {
            text-align: left;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .text-justify {
            text-align: justify;
        }
        .text-nowrap {
            white-space: nowrap;
        }
        .text-lowercase {
            text-transform: lowercase;
        }
        .text-uppercase {
            text-transform: uppercase;
        }
        .text-capitalize {
            text-transform: capitalize;
        }
        .text-muted {
            color: #777777;
        }
        .text-primary {
            color: #337ab7;
        }
        a.text-primary:hover,
        a.text-primary:focus {
            color: #286090;
        }
        .text-success {
            color: #3c763d;
        }
        a.text-success:hover,
        a.text-success:focus {
            color: #2b542c;
        }
        .text-info {
            color: #31708f;
        }
        a.text-info:hover,
        a.text-info:focus {
            color: #245269;
        }
        .text-warning {
            color: #8a6d3b;
        }
        a.text-warning:hover,
        a.text-warning:focus {
            color: #66512c;
        }
        .text-danger {
            color: #a94442;
        }
        a.text-danger:hover,
        a.text-danger:focus {
            color: #843534;
        }
        .bg-primary {
            color: #fff;
            background-color: #337ab7;
        }
        a.bg-primary:hover,
        a.bg-primary:focus {
            background-color: #286090;
        }
        .bg-success {
            background-color: #dff0d8;
        }
        a.bg-success:hover,
        a.bg-success:focus {
            background-color: #c1e2b3;
        }
        .bg-info {
            background-color: #d9edf7;
        }
        a.bg-info:hover,
        a.bg-info:focus {
            background-color: #afd9ee;
        }
        .bg-warning {
            background-color: #fcf8e3;
        }
        a.bg-warning:hover,
        a.bg-warning:focus {
            background-color: #f7ecb5;
        }
        .bg-danger {
            background-color: #f2dede;
        }
        a.bg-danger:hover,
        a.bg-danger:focus {
            background-color: #e4b9b9;
        }
        .page-header {
            padding-bottom: 9px;
            margin: 40px 0 20px;
            border-bottom: 1px solid #eeeeee;
        }
        ul,
        ol {
            margin-top: 0;
            margin-bottom: 10px;
        }
        ul ul,
        ol ul,
        ul ol,
        ol ol {
            margin-bottom: 0;
        }
        .list-unstyled {
            padding-left: 0;
            list-style: none;
        }
        .list-inline {
            padding-left: 0;
            list-style: none;
            margin-left: -5px;
        }
        .list-inline > li {
            display: inline-block;
            padding-left: 5px;
            padding-right: 5px;
        }
        dl {
            margin-top: 0;
            margin-bottom: 20px;
        }
        dt,
        dd {
            line-height: 1.42857143;
        }
        dt {
            font-weight: bold;
        }
        dd {
            margin-left: 0;
        }
        @media (min-width: 768px) {
            .dl-horizontal dt {
                float: left;
                width: 160px;
                clear: left;
                text-align: right;
                overflow: hidden;
                text-overflow: ellipsis;
                white-space: nowrap;
            }
            .dl-horizontal dd {
                margin-left: 180px;
            }
        }
        abbr[title],
        abbr[data-original-title] {
            cursor: help;
            border-bottom: 1px dotted #777777;
        }
        .initialism {
            font-size: 90%;
            text-transform: uppercase;
        }
        blockquote {
            padding: 10px 20px;
            margin: 0 0 20px;
            font-size: 17.5px;
            border-left: 5px solid #eeeeee;
        }
        blockquote p:last-child,
        blockquote ul:last-child,
        blockquote ol:last-child {
            margin-bottom: 0;
        }
        blockquote footer,
        blockquote small,
        blockquote .small {
            display: block;
            font-size: 80%;
            line-height: 1.42857143;
            color: #777777;
        }
        blockquote footer:before,
        blockquote small:before,
        blockquote .small:before {
            content: '\2014 \00A0';
        }
        .blockquote-reverse,
        blockquote.pull-right {
            padding-right: 15px;
            padding-left: 0;
            border-right: 5px solid #eeeeee;
            border-left: 0;
            text-align: right;
        }
        .blockquote-reverse footer:before,
        blockquote.pull-right footer:before,
        .blockquote-reverse small:before,
        blockquote.pull-right small:before,
        .blockquote-reverse .small:before,
        blockquote.pull-right .small:before {
            content: '';
        }
        .blockquote-reverse footer:after,
        blockquote.pull-right footer:after,
        .blockquote-reverse small:after,
        blockquote.pull-right small:after,
        .blockquote-reverse .small:after,
        blockquote.pull-right .small:after {
            content: '\00A0 \2014';
        }
        address {
            margin-bottom: 20px;
            font-style: normal;
            line-height: 1.42857143;
        }
        .container {
            margin-right: auto;
            margin-left: auto;
            padding-left: 15px;
            padding-right: 15px;
        }
        @media (min-width: 768px) {
            .container {
                width: 750px;
            }
        }
        @media (min-width: 992px) {
            .container {
                width: 970px;
            }
        }
        @media (min-width: 1200px) {
            .container {
                width: 1170px;
            }
        }
        .container-fluid {
            margin-right: auto;
            margin-left: auto;
            padding-left: 15px;
            padding-right: 15px;
        }
        .row {
            margin-left: -15px;
            margin-right: -15px;
        }
        .col-xs-1, .col-sm-1, .col-md-1, .col-lg-1, .col-xs-2, .col-sm-2, .col-md-2, .col-lg-2, .col-xs-3, .col-sm-3, .col-md-3, .col-lg-3, .col-xs-4, .col-sm-4, .col-md-4, .col-lg-4, .col-xs-5, .col-sm-5, .col-md-5, .col-lg-5, .col-xs-6, .col-sm-6, .col-md-6, .col-lg-6, .col-xs-7, .col-sm-7, .col-md-7, .col-lg-7, .col-xs-8, .col-sm-8, .col-md-8, .col-lg-8, .col-xs-9, .col-sm-9, .col-md-9, .col-lg-9, .col-xs-10, .col-sm-10, .col-md-10, .col-lg-10, .col-xs-11, .col-sm-11, .col-md-11, .col-lg-11, .col-xs-12, .col-sm-12, .col-md-12, .col-lg-12 {
            position: relative;
            min-height: 1px;
            padding-left: 15px;
            padding-right: 15px;
        }
        .col-xs-1, .col-xs-2, .col-xs-3, .col-xs-4, .col-xs-5, .col-xs-6, .col-xs-7, .col-xs-8, .col-xs-9, .col-xs-10, .col-xs-11, .col-xs-12 {
            float: left;
        }
        .col-xs-12 {
            width: 100%;
        }
        .col-xs-11 {
            width: 91.66666667%;
        }
        .col-xs-10 {
            width: 83.33333333%;
        }
        .col-xs-9 {
            width: 75%;
        }
        .col-xs-8 {
            width: 66.66666667%;
        }
        .col-xs-7 {
            width: 58.33333333%;
        }
        .col-xs-6 {
            width: 50%;
        }
        .col-xs-5 {
            width: 41.66666667%;
        }
        .col-xs-4 {
            width: 33.33333333%;
        }
        .col-xs-3 {
            width: 25%;
        }
        .col-xs-2 {
            width: 16.66666667%;
        }
        .col-xs-1 {
            width: 8.33333333%;
        }
        .col-xs-pull-12 {
            right: 100%;
        }
        .col-xs-pull-11 {
            right: 91.66666667%;
        }
        .col-xs-pull-10 {
            right: 83.33333333%;
        }
        .col-xs-pull-9 {
            right: 75%;
        }
        .col-xs-pull-8 {
            right: 66.66666667%;
        }
        .col-xs-pull-7 {
            right: 58.33333333%;
        }
        .col-xs-pull-6 {
            right: 50%;
        }
        .col-xs-pull-5 {
            right: 41.66666667%;
        }
        .col-xs-pull-4 {
            right: 33.33333333%;
        }
        .col-xs-pull-3 {
            right: 25%;
        }
        .col-xs-pull-2 {
            right: 16.66666667%;
        }
        .col-xs-pull-1 {
            right: 8.33333333%;
        }
        .col-xs-pull-0 {
            right: auto;
        }
        .col-xs-push-12 {
            left: 100%;
        }
        .col-xs-push-11 {
            left: 91.66666667%;
        }
        .col-xs-push-10 {
            left: 83.33333333%;
        }
        .col-xs-push-9 {
            left: 75%;
        }
        .col-xs-push-8 {
            left: 66.66666667%;
        }
        .col-xs-push-7 {
            left: 58.33333333%;
        }
        .col-xs-push-6 {
            left: 50%;
        }
        .col-xs-push-5 {
            left: 41.66666667%;
        }
        .col-xs-push-4 {
            left: 33.33333333%;
        }
        .col-xs-push-3 {
            left: 25%;
        }
        .col-xs-push-2 {
            left: 16.66666667%;
        }
        .col-xs-push-1 {
            left: 8.33333333%;
        }
        .col-xs-push-0 {
            left: auto;
        }
        .col-xs-offset-12 {
            margin-left: 100%;
        }
        .col-xs-offset-11 {
            margin-left: 91.66666667%;
        }
        .col-xs-offset-10 {
            margin-left: 83.33333333%;
        }
        .col-xs-offset-9 {
            margin-left: 75%;
        }
        .col-xs-offset-8 {
            margin-left: 66.66666667%;
        }
        .col-xs-offset-7 {
            margin-left: 58.33333333%;
        }
        .col-xs-offset-6 {
            margin-left: 50%;
        }
        .col-xs-offset-5 {
            margin-left: 41.66666667%;
        }
        .col-xs-offset-4 {
            margin-left: 33.33333333%;
        }
        .col-xs-offset-3 {
            margin-left: 25%;
        }
        .col-xs-offset-2 {
            margin-left: 16.66666667%;
        }
        .col-xs-offset-1 {
            margin-left: 8.33333333%;
        }
        .col-xs-offset-0 {
            margin-left: 0%;
        }
        @media (min-width: 768px) {
            .col-sm-1, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-sm-10, .col-sm-11, .col-sm-12 {
                float: left;
            }
            .col-sm-12 {
                width: 100%;
            }
            .col-sm-11 {
                width: 91.66666667%;
            }
            .col-sm-10 {
                width: 83.33333333%;
            }
            .col-sm-9 {
                width: 75%;
            }
            .col-sm-8 {
                width: 66.66666667%;
            }
            .col-sm-7 {
                width: 58.33333333%;
            }
            .col-sm-6 {
                width: 50%;
            }
            .col-sm-5 {
                width: 41.66666667%;
            }
            .col-sm-4 {
                width: 33.33333333%;
            }
            .col-sm-3 {
                width: 25%;
            }
            .col-sm-2 {
                width: 16.66666667%;
            }
            .col-sm-1 {
                width: 8.33333333%;
            }
            .col-sm-pull-12 {
                right: 100%;
            }
            .col-sm-pull-11 {
                right: 91.66666667%;
            }
            .col-sm-pull-10 {
                right: 83.33333333%;
            }
            .col-sm-pull-9 {
                right: 75%;
            }
            .col-sm-pull-8 {
                right: 66.66666667%;
            }
            .col-sm-pull-7 {
                right: 58.33333333%;
            }
            .col-sm-pull-6 {
                right: 50%;
            }
            .col-sm-pull-5 {
                right: 41.66666667%;
            }
            .col-sm-pull-4 {
                right: 33.33333333%;
            }
            .col-sm-pull-3 {
                right: 25%;
            }
            .col-sm-pull-2 {
                right: 16.66666667%;
            }
            .col-sm-pull-1 {
                right: 8.33333333%;
            }
            .col-sm-pull-0 {
                right: auto;
            }
            .col-sm-push-12 {
                left: 100%;
            }
            .col-sm-push-11 {
                left: 91.66666667%;
            }
            .col-sm-push-10 {
                left: 83.33333333%;
            }
            .col-sm-push-9 {
                left: 75%;
            }
            .col-sm-push-8 {
                left: 66.66666667%;
            }
            .col-sm-push-7 {
                left: 58.33333333%;
            }
            .col-sm-push-6 {
                left: 50%;
            }
            .col-sm-push-5 {
                left: 41.66666667%;
            }
            .col-sm-push-4 {
                left: 33.33333333%;
            }
            .col-sm-push-3 {
                left: 25%;
            }
            .col-sm-push-2 {
                left: 16.66666667%;
            }
            .col-sm-push-1 {
                left: 8.33333333%;
            }
            .col-sm-push-0 {
                left: auto;
            }
            .col-sm-offset-12 {
                margin-left: 100%;
            }
            .col-sm-offset-11 {
                margin-left: 91.66666667%;
            }
            .col-sm-offset-10 {
                margin-left: 83.33333333%;
            }
            .col-sm-offset-9 {
                margin-left: 75%;
            }
            .col-sm-offset-8 {
                margin-left: 66.66666667%;
            }
            .col-sm-offset-7 {
                margin-left: 58.33333333%;
            }
            .col-sm-offset-6 {
                margin-left: 50%;
            }
            .col-sm-offset-5 {
                margin-left: 41.66666667%;
            }
            .col-sm-offset-4 {
                margin-left: 33.33333333%;
            }
            .col-sm-offset-3 {
                margin-left: 25%;
            }
            .col-sm-offset-2 {
                margin-left: 16.66666667%;
            }
            .col-sm-offset-1 {
                margin-left: 8.33333333%;
            }
            .col-sm-offset-0 {
                margin-left: 0%;
            }
        }
        @media (min-width: 992px) {
            .col-md-1, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-md-10, .col-md-11, .col-md-12 {
                float: left;
            }
            .col-md-12 {
                width: 100%;
            }
            .col-md-11 {
                width: 91.66666667%;
            }
            .col-md-10 {
                width: 83.33333333%;
            }
            .col-md-9 {
                width: 75%;
            }
            .col-md-8 {
                width: 66.66666667%;
            }
            .col-md-7 {
                width: 58.33333333%;
            }
            .col-md-6 {
                width: 50%;
            }
            .col-md-5 {
                width: 41.66666667%;
            }
            .col-md-4 {
                width: 33.33333333%;
            }
            .col-md-3 {
                width: 25%;
            }
            .col-md-2 {
                width: 16.66666667%;
            }
            .col-md-1 {
                width: 8.33333333%;
            }
            .col-md-pull-12 {
                right: 100%;
            }
            .col-md-pull-11 {
                right: 91.66666667%;
            }
            .col-md-pull-10 {
                right: 83.33333333%;
            }
            .col-md-pull-9 {
                right: 75%;
            }
            .col-md-pull-8 {
                right: 66.66666667%;
            }
            .col-md-pull-7 {
                right: 58.33333333%;
            }
            .col-md-pull-6 {
                right: 50%;
            }
            .col-md-pull-5 {
                right: 41.66666667%;
            }
            .col-md-pull-4 {
                right: 33.33333333%;
            }
            .col-md-pull-3 {
                right: 25%;
            }
            .col-md-pull-2 {
                right: 16.66666667%;
            }
            .col-md-pull-1 {
                right: 8.33333333%;
            }
            .col-md-pull-0 {
                right: auto;
            }
            .col-md-push-12 {
                left: 100%;
            }
            .col-md-push-11 {
                left: 91.66666667%;
            }
            .col-md-push-10 {
                left: 83.33333333%;
            }
            .col-md-push-9 {
                left: 75%;
            }
            .col-md-push-8 {
                left: 66.66666667%;
            }
            .col-md-push-7 {
                left: 58.33333333%;
            }
            .col-md-push-6 {
                left: 50%;
            }
            .col-md-push-5 {
                left: 41.66666667%;
            }
            .col-md-push-4 {
                left: 33.33333333%;
            }
            .col-md-push-3 {
                left: 25%;
            }
            .col-md-push-2 {
                left: 16.66666667%;
            }
            .col-md-push-1 {
                left: 8.33333333%;
            }
            .col-md-push-0 {
                left: auto;
            }
            .col-md-offset-12 {
                margin-left: 100%;
            }
            .col-md-offset-11 {
                margin-left: 91.66666667%;
            }
            .col-md-offset-10 {
                margin-left: 83.33333333%;
            }
            .col-md-offset-9 {
                margin-left: 75%;
            }
            .col-md-offset-8 {
                margin-left: 66.66666667%;
            }
            .col-md-offset-7 {
                margin-left: 58.33333333%;
            }
            .col-md-offset-6 {
                margin-left: 50%;
            }
            .col-md-offset-5 {
                margin-left: 41.66666667%;
            }
            .col-md-offset-4 {
                margin-left: 33.33333333%;
            }
            .col-md-offset-3 {
                margin-left: 25%;
            }
            .col-md-offset-2 {
                margin-left: 16.66666667%;
            }
            .col-md-offset-1 {
                margin-left: 8.33333333%;
            }
            .col-md-offset-0 {
                margin-left: 0%;
            }
        }
        @media (min-width: 1200px) {
            .col-lg-1, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9, .col-lg-10, .col-lg-11, .col-lg-12 {
                float: left;
            }
            .col-lg-12 {
                width: 100%;
            }
            .col-lg-11 {
                width: 91.66666667%;
            }
            .col-lg-10 {
                width: 83.33333333%;
            }
            .col-lg-9 {
                width: 75%;
            }
            .col-lg-8 {
                width: 66.66666667%;
            }
            .col-lg-7 {
                width: 58.33333333%;
            }
            .col-lg-6 {
                width: 50%;
            }
            .col-lg-5 {
                width: 41.66666667%;
            }
            .col-lg-4 {
                width: 33.33333333%;
            }
            .col-lg-3 {
                width: 25%;
            }
            .col-lg-2 {
                width: 16.66666667%;
            }
            .col-lg-1 {
                width: 8.33333333%;
            }
            .col-lg-pull-12 {
                right: 100%;
            }
            .col-lg-pull-11 {
                right: 91.66666667%;
            }
            .col-lg-pull-10 {
                right: 83.33333333%;
            }
            .col-lg-pull-9 {
                right: 75%;
            }
            .col-lg-pull-8 {
                right: 66.66666667%;
            }
            .col-lg-pull-7 {
                right: 58.33333333%;
            }
            .col-lg-pull-6 {
                right: 50%;
            }
            .col-lg-pull-5 {
                right: 41.66666667%;
            }
            .col-lg-pull-4 {
                right: 33.33333333%;
            }
            .col-lg-pull-3 {
                right: 25%;
            }
            .col-lg-pull-2 {
                right: 16.66666667%;
            }
            .col-lg-pull-1 {
                right: 8.33333333%;
            }
            .col-lg-pull-0 {
                right: auto;
            }
            .col-lg-push-12 {
                left: 100%;
            }
            .col-lg-push-11 {
                left: 91.66666667%;
            }
            .col-lg-push-10 {
                left: 83.33333333%;
            }
            .col-lg-push-9 {
                left: 75%;
            }
            .col-lg-push-8 {
                left: 66.66666667%;
            }
            .col-lg-push-7 {
                left: 58.33333333%;
            }
            .col-lg-push-6 {
                left: 50%;
            }
            .col-lg-push-5 {
                left: 41.66666667%;
            }
            .col-lg-push-4 {
                left: 33.33333333%;
            }
            .col-lg-push-3 {
                left: 25%;
            }
            .col-lg-push-2 {
                left: 16.66666667%;
            }
            .col-lg-push-1 {
                left: 8.33333333%;
            }
            .col-lg-push-0 {
                left: auto;
            }
            .col-lg-offset-12 {
                margin-left: 100%;
            }
            .col-lg-offset-11 {
                margin-left: 91.66666667%;
            }
            .col-lg-offset-10 {
                margin-left: 83.33333333%;
            }
            .col-lg-offset-9 {
                margin-left: 75%;
            }
            .col-lg-offset-8 {
                margin-left: 66.66666667%;
            }
            .col-lg-offset-7 {
                margin-left: 58.33333333%;
            }
            .col-lg-offset-6 {
                margin-left: 50%;
            }
            .col-lg-offset-5 {
                margin-left: 41.66666667%;
            }
            .col-lg-offset-4 {
                margin-left: 33.33333333%;
            }
            .col-lg-offset-3 {
                margin-left: 25%;
            }
            .col-lg-offset-2 {
                margin-left: 16.66666667%;
            }
            .col-lg-offset-1 {
                margin-left: 8.33333333%;
            }
            .col-lg-offset-0 {
                margin-left: 0%;
            }
        }
        table {
            background-color: transparent;
        }
        caption {
            padding-top: 8px;
            padding-bottom: 8px;
            color: #777777;
            text-align: left;
        }
        th {
            text-align: left;
        }
        .table {
            width: 100%;
            max-width: 100%;
            margin-bottom: 20px;
        }
        .table > thead > tr > th,
        .table > tbody > tr > th,
        .table > tfoot > tr > th,
        .table > thead > tr > td,
        .table > tbody > tr > td,
        .table > tfoot > tr > td {
            padding: 8px;
            line-height: 1.42857143;
            vertical-align: top;
            border-top: 1px solid #dddddd;
        }
        .table > thead > tr > th {
            vertical-align: bottom;
            border-bottom: 2px solid #dddddd;
        }
        .table > caption + thead > tr:first-child > th,
        .table > colgroup + thead > tr:first-child > th,
        .table > thead:first-child > tr:first-child > th,
        .table > caption + thead > tr:first-child > td,
        .table > colgroup + thead > tr:first-child > td,
        .table > thead:first-child > tr:first-child > td {
            border-top: 0;
        }
        .table > tbody + tbody {
            border-top: 2px solid #dddddd;
        }
        .table .table {
            background-color: #ffffff;
        }
        .table-condensed > thead > tr > th,
        .table-condensed > tbody > tr > th,
        .table-condensed > tfoot > tr > th,
        .table-condensed > thead > tr > td,
        .table-condensed > tbody > tr > td,
        .table-condensed > tfoot > tr > td {
            padding: 5px;
        }
        .table-bordered {
            border: 1px solid #dddddd;
        }
        .table-bordered > thead > tr > th,
        .table-bordered > tbody > tr > th,
        .table-bordered > tfoot > tr > th,
        .table-bordered > thead > tr > td,
        .table-bordered > tbody > tr > td,
        .table-bordered > tfoot > tr > td {
            border: 1px solid #dddddd;
        }
        .table-bordered > thead > tr > th,
        .table-bordered > thead > tr > td {
            border-bottom-width: 2px;
        }
        .table-striped > tbody > tr:nth-of-type(odd) {
            background-color: #f9f9f9;
        }
        .table-hover > tbody > tr:hover {
            background-color: #f5f5f5;
        }
        table col[class*="col-"] {
            position: static;
            float: none;
            display: table-column;
        }
        table td[class*="col-"],
        table th[class*="col-"] {
            position: static;
            float: none;
            display: table-cell;
        }
        .table > thead > tr > td.active,
        .table > tbody > tr > td.active,
        .table > tfoot > tr > td.active,
        .table > thead > tr > th.active,
        .table > tbody > tr > th.active,
        .table > tfoot > tr > th.active,
        .table > thead > tr.active > td,
        .table > tbody > tr.active > td,
        .table > tfoot > tr.active > td,
        .table > thead > tr.active > th,
        .table > tbody > tr.active > th,
        .table > tfoot > tr.active > th {
            background-color: #f5f5f5;
        }
        .table-hover > tbody > tr > td.active:hover,
        .table-hover > tbody > tr > th.active:hover,
        .table-hover > tbody > tr.active:hover > td,
        .table-hover > tbody > tr:hover > .active,
        .table-hover > tbody > tr.active:hover > th {
            background-color: #e8e8e8;
        }
        .table > thead > tr > td.success,
        .table > tbody > tr > td.success,
        .table > tfoot > tr > td.success,
        .table > thead > tr > th.success,
        .table > tbody > tr > th.success,
        .table > tfoot > tr > th.success,
        .table > thead > tr.success > td,
        .table > tbody > tr.success > td,
        .table > tfoot > tr.success > td,
        .table > thead > tr.success > th,
        .table > tbody > tr.success > th,
        .table > tfoot > tr.success > th {
            background-color: #dff0d8;
        }
        .table-hover > tbody > tr > td.success:hover,
        .table-hover > tbody > tr > th.success:hover,
        .table-hover > tbody > tr.success:hover > td,
        .table-hover > tbody > tr:hover > .success,
        .table-hover > tbody > tr.success:hover > th {
            background-color: #d0e9c6;
        }
        .table > thead > tr > td.info,
        .table > tbody > tr > td.info,
        .table > tfoot > tr > td.info,
        .table > thead > tr > th.info,
        .table > tbody > tr > th.info,
        .table > tfoot > tr > th.info,
        .table > thead > tr.info > td,
        .table > tbody > tr.info > td,
        .table > tfoot > tr.info > td,
        .table > thead > tr.info > th,
        .table > tbody > tr.info > th,
        .table > tfoot > tr.info > th {
            background-color: #d9edf7;
        }
        .table-hover > tbody > tr > td.info:hover,
        .table-hover > tbody > tr > th.info:hover,
        .table-hover > tbody > tr.info:hover > td,
        .table-hover > tbody > tr:hover > .info,
        .table-hover > tbody > tr.info:hover > th {
            background-color: #c4e3f3;
        }
        .table > thead > tr > td.warning,
        .table > tbody > tr > td.warning,
        .table > tfoot > tr > td.warning,
        .table > thead > tr > th.warning,
        .table > tbody > tr > th.warning,
        .table > tfoot > tr > th.warning,
        .table > thead > tr.warning > td,
        .table > tbody > tr.warning > td,
        .table > tfoot > tr.warning > td,
        .table > thead > tr.warning > th,
        .table > tbody > tr.warning > th,
        .table > tfoot > tr.warning > th {
            background-color: #fcf8e3;
        }
        .table-hover > tbody > tr > td.warning:hover,
        .table-hover > tbody > tr > th.warning:hover,
        .table-hover > tbody > tr.warning:hover > td,
        .table-hover > tbody > tr:hover > .warning,
        .table-hover > tbody > tr.warning:hover > th {
            background-color: #faf2cc;
        }
        .table > thead > tr > td.danger,
        .table > tbody > tr > td.danger,
        .table > tfoot > tr > td.danger,
        .table > thead > tr > th.danger,
        .table > tbody > tr > th.danger,
        .table > tfoot > tr > th.danger,
        .table > thead > tr.danger > td,
        .table > tbody > tr.danger > td,
        .table > tfoot > tr.danger > td,
        .table > thead > tr.danger > th,
        .table > tbody > tr.danger > th,
        .table > tfoot > tr.danger > th {
            background-color: #f2dede;
        }
        .table-hover > tbody > tr > td.danger:hover,
        .table-hover > tbody > tr > th.danger:hover,
        .table-hover > tbody > tr.danger:hover > td,
        .table-hover > tbody > tr:hover > .danger,
        .table-hover > tbody > tr.danger:hover > th {
            background-color: #ebcccc;
        }
        .table-responsive {
            overflow-x: auto;
            min-height: 0.01%;
        }
        @media screen and (max-width: 767px) {
            .table-responsive {
                width: 100%;
                margin-bottom: 15px;
                overflow-y: hidden;
                -ms-overflow-style: -ms-autohiding-scrollbar;
                border: 1px solid #dddddd;
            }
            .table-responsive > .table {
                margin-bottom: 0;
            }
            .table-responsive > .table > thead > tr > th,
            .table-responsive > .table > tbody > tr > th,
            .table-responsive > .table > tfoot > tr > th,
            .table-responsive > .table > thead > tr > td,
            .table-responsive > .table > tbody > tr > td,
            .table-responsive > .table > tfoot > tr > td {
                white-space: nowrap;
            }
            .table-responsive > .table-bordered {
                border: 0;
            }
            .table-responsive > .table-bordered > thead > tr > th:first-child,
            .table-responsive > .table-bordered > tbody > tr > th:first-child,
            .table-responsive > .table-bordered > tfoot > tr > th:first-child,
            .table-responsive > .table-bordered > thead > tr > td:first-child,
            .table-responsive > .table-bordered > tbody > tr > td:first-child,
            .table-responsive > .table-bordered > tfoot > tr > td:first-child {
                border-left: 0;
            }
            .table-responsive > .table-bordered > thead > tr > th:last-child,
            .table-responsive > .table-bordered > tbody > tr > th:last-child,
            .table-responsive > .table-bordered > tfoot > tr > th:last-child,
            .table-responsive > .table-bordered > thead > tr > td:last-child,
            .table-responsive > .table-bordered > tbody > tr > td:last-child,
            .table-responsive > .table-bordered > tfoot > tr > td:last-child {
                border-right: 0;
            }
            .table-responsive > .table-bordered > tbody > tr:last-child > th,
            .table-responsive > .table-bordered > tfoot > tr:last-child > th,
            .table-responsive > .table-bordered > tbody > tr:last-child > td,
            .table-responsive > .table-bordered > tfoot > tr:last-child > td {
                border-bottom: 0;
            }
        }
        .clearfix:before,
        .clearfix:after,
        .dl-horizontal dd:before,
        .dl-horizontal dd:after,
        .container:before,
        .container:after,
        .container-fluid:before,
        .container-fluid:after,
        .row:before,
        .row:after {
            content: " ";
            display: table;
        }
        .clearfix:after,
        .dl-horizontal dd:after,
        .container:after,
        .container-fluid:after,
        .row:after {
            clear: both;
        }
        .center-block {
            display: block;
            margin-left: auto;
            margin-right: auto;
        }
        .pull-right {
            float: right !important;
        }
        .pull-left {
            float: left !important;
        }
        .hide {
            display: none !important;
        }
        .show {
            display: block !important;
        }
        .invisible {
            visibility: hidden;
        }
        .text-hide {
            font: 0/0 a;
            color: transparent;
            text-shadow: none;
            background-color: transparent;
            border: 0;
        }
        .hidden {
            display: none !important;
        }
        .affix {
            position: fixed;
        }

    </style>

</head>
<body class="hold-transition">


<div class="container">
    <table class="table">
        <tr>
            <td style="width:150px">
                <img src="{{ asset('images/login_logo.png') }}" alt="{{ $milyPosSettings->site_name }}">
            </td>
            <td style="background-color:white; width:140px">
                Flat # 3A, House# 48, Road # 3, Block #G, Banasree, Rampura, Dhaka
            </td>
            <td style="background-color:white; width:140px">
                <abbr title="Phone">P:</abbr> (123) 456-7890
                <br><abbr title="Email">E:</abbr> ifte510@gmail.com
            </td>
            <td class="text-center" style="background-color:white; width:110px; text-align:center;">
                <strong style="font-size: 20px">INVOICE # <br>{{ $sale->code }}</strong>
            </td>
        </tr>
    </table>
    <hr>

    <div class="row">
        <div class="col-md-12">
            <table class="table table-striped table-bordered table-condensed">
                <tr>
                    <th>Client:</th>
                    <td>{{ $sale->client->fullName }}</td>
                    <th>Date:</th>
                    <td>{{ $sale->created_at }}</td>
                </tr>
                <tr>
                    <th>Seller:</th>
                    <td colspan="3">
                        {{ $sale->user->fullName }}
                    </td>
                </tr>
            </table>
        </div><!-- col-md-12 -->
    </div><!-- row -->


    <div style="margin-top: 50px;"></div>
    <div class="row">
        <div class="col-md-12">
            <table class="table">
                <thead>
                <tr>
                    <th>Products</th>
                    <th>Quantity</th>
                    <th>UnitPrice</th>
                    <th>Total</th>
                </tr>
                </thead>

                <tbody>

                @foreach($products as $key => $value)
                    <tr>
                        <td>{{ $value['name'] }}</td>
                        <td>{{ $value['quantity'] }}</td>
                        <td>{{ $value['price'] }}</td>
                        <td>{{ $value['total'] }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="2">&nbsp;</td>
                    <th>Sub Total</th>
                    <td>{{ $sale->subtotal }}</td>
                </tr>
                <tr>
                    <td colspan="2">&nbsp;</td>
                    <th>Tax</th>
                    <td>{{ $sale->subtotal*$sale->tax/100 }}</td>
                </tr>

                <tr>
                    <td colspan="2">&nbsp;</td>
                    <th>Total Payable</th>
                    <td>{{ $sale->total }}</td>
                </tr>
                </tbody>
            </table>

        </div><!-- .col-md-3 -->
    </div><!-- .row -->




    <div style="margin-top: 50px;"></div>

    <div class="row">
        <div class="col-md-offset-6 col-md-6">

        </div><!-- .col-md-3 -->
    </div><!-- .row -->


</div><!-- container -->

<script src="{{ asset('js/all.js') }}"></script>

{{-- Page Specific Scripts--}}
@yield('page_scripts')
</body>
</html>
