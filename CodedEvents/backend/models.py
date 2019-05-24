from django.db import models
from django.contrib.auth.models import AbstractUser, AbstractBaseUser, PermissionsMixin
from django.utils.translation import ugettext_lazy as _
from .managers import CustomUserManager
from django.utils import timezone

# TODO: Add more commenting/explanation
# TODO: Create tests for these models, perhaps using django-faker
# TODO: Explain attributes i.e. on_delete
class Role(models.Model):
    name = models.CharField(max_length=30)
    desc = models.CharField(max_length=100)


# This extend the default User model provided by Django, this allows you to store
# non-auth related information about a user.
class Profile(AbstractUser):
    username = None
    email = models.EmailField(_('email address'), unique=True)
    roles = models.ManyToManyField(Role)

    USERNAME_FIELD = 'email'
    REQUIRED_FIELDS = []

    objects = CustomUserManager()

    def __str__(self):
        return self.email


class Address(models.Model):
    street = models.CharField(max_length=255, null=True)
    city = models.CharField(max_length=100, null=True)
    province = models.CharField(max_length=30, null=True)
    code = models.CharField(max_length=30, null=True)

    class Meta:
        verbose_name_plural = 'Addresses'


class Category(models.Model):
    name = models.CharField(max_length=30)
    desc = models.CharField(max_length=100)

    class Meta:
        verbose_name_plural = 'Categories'


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
    user = models.ForeignKey(Profile, on_delete=models.CASCADE)
