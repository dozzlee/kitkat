"""CodedEvents URL Configuration

The `urlpatterns` list routes URLs to views. For more information please see:
    https://docs.djangoproject.com/en/2.2/topics/http/urls/
Examples:
Function views
    1. Add an import:  from my_app import views
    2. Add a URL to urlpatterns:  path('', views.home, name='home')
Class-based views
    1. Add an import:  from other_app.views import Home
    2. Add a URL to urlpatterns:  path('', Home.as_view(), name='home')
Including another URLconf
    1. Import the include() function: from django.urls import include, path
    2. Add a URL to urlpatterns:  path('blog/', include('blog.urls'))
"""

from django.conf import settings
from django.conf.urls.static import static
from django.contrib import admin
from django.urls import path, re_path, include
from django.conf.urls import url
from backend.swagger_schema import SwaggerSchemaView
from rest_framework import permissions
from drf_yasg.views import get_schema_view
from drf_yasg import openapi
import backend.pages as pages

schema_view = get_schema_view(
   openapi.Info(
      title="KitKat API",
      default_version='v1',
      description="Event Ticketing API endpoint",
      contact=openapi.Contact(email="contact@coded.local"),
      license=openapi.License(name="BSD License"),
   ),
   public=True,
   permission_classes=(permissions.AllowAny,),
)

urlpatterns = [
    path('admin/', admin.site.urls),
    url(r'^api-auth/', include('rest_framework.urls', namespace='rest_framework')),
    # Authentication
    path('o/', include('oauth2_provider.urls', namespace='oauth2_provider')),
    #API
    # url(r'', include('backend.urls')),
    re_path(r'^api/v1/', include('backend.urls')),
    url(r'^swagger/$', SwaggerSchemaView.as_view()),
    url(r'^redoc/$', schema_view.with_ui('redoc', cache_timeout=0), name='schema-redoc'),
    #Pageviews
    path('backend/', pages.index, name='index'),
    path('backend/admin/events', pages.AdminEventList, name='admin_event_list'),
    path('backend/admin/events/new', pages.AdminEventAdd, name='admin_event_add'),
    path('backend/admin/orders', pages.AdminOrdersList, name='admin_event_orders'),
    path('backend/events/view/<int:id>', pages.EventView, name='event_view'),      
]
urlpatterns+= static(settings.STATIC_URL, document_root=settings.STATIC_ROOT)
urlpatterns += [
    path('accounts/', include('django.contrib.auth.urls')),
]