from django.conf.urls import url
from django.urls import path, include
from .views import *
from rest_framework.routers import DefaultRouter

#Register routes
router = DefaultRouter()
router.register(r'users', UserViewSet)
router.register(r'roles', RolesViewSet)
router.register(r'ticket', TicketViewSet)
router.register(r'event', EventViewSet)
router.register(r'booking', BookingViewSet)
router.register(r'address', AddressViewSet)
router.register(r'category', CategoryViewSet)

urlpatterns = [
    url(r'', include(router.urls)),
    path('oauth/', include('backend.oauth')),
]