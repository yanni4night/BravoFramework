<center>Action from <strong>{{__self.getName()}}</strong> in <strong>{{app}}</strong></center>
{%if app%}
<center>Message in IF</center>
{%endif%}

<pre>
{% autoescape false %}
{{__self.load('Index:Hello')}}
</pre>
{% endautoescape %}