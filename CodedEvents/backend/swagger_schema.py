from rest_framework.permissions import AllowAny
from rest_framework.response import Response
from rest_framework.views import APIView
from rest_framework_swagger import renderers
from rest_framework.schemas import SchemaGenerator
from urllib.parse import urljoin
import yaml
import coreapi
from rest_framework.routers import DefaultRouter
from backend.views import *
from django.conf.urls import url,include

class CustomSchemaGenerator(SchemaGenerator):
    def get_link(self, path, method, view):
        """
        Customized Schema generator:
        if __doc__ of the function exists, use the __doc__ to build the schema.
        else use the default serializer.
        """

        fields = self.get_path_fields(path, method, view)
        yaml_doc = None

        # Check and load if the function has __doc__
        if view and view.__doc__:
            try:
                yaml_doc = yaml.load(view.__doc__)
            except:
                yaml_doc = None

        #Extract schema information from yaml

        if yaml_doc and type(yaml_doc) != str:
            _method_desc = yaml_doc.get('description', '')
            params = yaml_doc.get('parameters', [])

            for i in params:
                _name = i.get('name')
                _desc = i.get('description')
                _required = i.get('required', False)
                _type = i.get('type', 'string')
                _location = i.get('location', 'form')
                field = coreapi.Field(
                    name=_name,
                    location=_location,
                    required=_required,
                    description=_desc,
                    type=_type
                )
                fields.append(field)
        else:
            _method_desc = view.__doc__ if view and view.__doc__ else ''
            fields += self.get_serializer_fields(path, method, view)

        fields += self.get_pagination_fields(path, method, view)
        fields += self.get_filter_fields(path, method, view)

        if fields and any([field.location in ('form', 'body') for field in fields]):
            encoding = self.get_encoding(path, method, view)
        else:
            encoding = None

        if self.url and path.startswith('/'):
            path = path[1:]

        return coreapi.Link(
            url=urljoin(self.url, path),
            action=method.lower(),
            encoding=encoding,
            fields=fields,
            description=_method_desc,
            title='KitKat API',
            basePath='api/v1',
        )


class SwaggerSchemaView(APIView):
    exclude_from_schema = True
    permission_classes = [AllowAny]
    renderer_classes = [
        renderers.OpenAPIRenderer,
        renderers.SwaggerUIRenderer
    ]

    def get(self, request):
        # Use Custom schema generator to generate schema
        urlpatterns = [
            url(r'^api/v1/', include('backend.urls')),
        ]

        generator = SchemaGenerator(title='KitKat API', patterns=urlpatterns)
        # generator = CustomSchemaGenerator()
        schema = generator.get_schema(request=request)

        return Response(schema)