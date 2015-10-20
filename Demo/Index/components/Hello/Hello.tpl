<div class="row">
    <h2>{{__self.getPath()}}</h2>
    {{user.name}}
</div>

{% autoescape false %}
{{__self.load('Index:World', {'user':{'name':'night'}}) }}
{% endautoescape %}