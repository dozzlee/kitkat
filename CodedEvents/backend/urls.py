from django.conf.urls import url
from django.urls import path
# from .views.address import ListAddressView
from rest_framework_swagger.views import get_swagger_view

# Create your views here.
schema_view = get_swagger_view(title='KitKat')

urlpatterns = [
    url(r'^$',schema_view),
    # path('address/', ListAddressView.as_view(), name="address-all"),
]