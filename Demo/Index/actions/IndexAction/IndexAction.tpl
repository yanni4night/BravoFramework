<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8"/>
    <title>Index</title>
    <meta name="keywords" content=""/>
    <meta name="description" content="This is auto-generated by sublime-custom-insert"/>
    <meta name="revised" value="yanni4night,2015/10/20"/>
    <style type="text/css">
    .row {
        border: 1px solid #ccc;
        margin: 10px;
    }
    </style>
  </head>
  <body>
  <h1>{{app}}</h1>
  <div class="row">
      <h2>{{__self.getPath()}}</h2>
  </div>
    {% autoescape false %}
    {{__self.load('Index:Hello', user)}}
    {% endautoescape %}

  </body>
  <script type="text/javascript"></script>
</html>