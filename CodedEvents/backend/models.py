from django.db import models
from django.contrib.auth.models import User


class Role(models.Model):
    name = models.CharField(max_length=30)
    desc = models.CharField(max_length=100)


class Profile(models.Model):
    user = models.OneToOneField(User, on_delete=models.CASCADE)
    roles = models.ManyToManyField(Role)


class Address(models.Model):
    street = models.TextField
    city = models.TextField
    province = models.TextField
    code = models.TextField


class Category(models.Model):
    name = models.CharField(max_length=30)
    desc = models.CharField(max_length=100)


class Event(models.Model):
    name = models.CharField(max_length=30)
    desc = models.CharField(max_length=100)
    organizers = models.ManyToManyField(Profile)
    address = models.ForeignKey(Address, on_delete=models.CASCADE)
    tickets_available = models.IntegerField
    check_ins = models.IntegerField
    start_time = models.DateTimeField
    end_time = models.DateTimeField
    registration_opens = models.DateTimeField
    categories = models.ManyToManyField(Category)


class Ticket(models.Model):
    event = models.ForeignKey(Event, on_delete=models.CASCADE)
    quantity = models.IntegerField
    price = models.FloatField
    status = models.CharField(max_length=30)
    shut_off_time = models.DateTimeField


class Booking(models.Model):
    ticket = models.ForeignKey(Ticket, on_delete=models.CASCADE)
    user = models.ForeignKey(User, on_delete=models.CASCADE)
