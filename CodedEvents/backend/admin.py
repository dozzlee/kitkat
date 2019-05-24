from django.contrib import admin
from .models import Profile, Role, Address, Category, Event, Ticket, Booking

# Register your models here.
admin.site.register(Profile)
admin.site.register(Role)
admin.site.register(Address)
admin.site.register(Category)
admin.site.register(Event)
admin.site.register(Ticket)
admin.site.register(Booking)
