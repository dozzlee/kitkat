from rest_framework import serializers
from .models import Profile, Role, Address, Category, Event, Ticket, Booking
from rest_framework import serializers

class RoleSerializer(serializers.HyperlinkedModelSerializer):

    class Meta:
        model = Role
        fields = ('id', 'name', 'desc')


class ProfileSerializer(serializers.ModelSerializer):

    def create(self, validated_data):
        user = Profile.objects.create_user(**validated_data)
        return user

    class Meta:
        model = Profile
        fields = ('id', 'first_name', 'last_name', 'email', 'password', 'roles', 
        'last_login', 'is_superuser', 'is_staff', 'is_active', 
        'date_joined', 'roles')

        extra_kwargs = {
            'password': {'write_only': True}
        }

class ProfileCreateSerializer(serializers.ModelSerializer):
    
    def create(self, validated_data):
        user = Profile.objects.create_user(**validated_data)
        return user

    class Meta:
        model = Profile
        fields = ('first_name', 'last_name', 'email', 'password')

        extra_kwargs = {
            'password': {'write_only': True}
        }

class AddressSerializer(serializers.ModelSerializer):

    class Meta:
        model = Address
        fields = '__all__'

class CategorySerializer(serializers.ModelSerializer):

    class Meta:
        model = Category
        fields = '__all__'

class TicketSerializer(serializers.ModelSerializer):

    class Meta:
        model = Ticket
        fields = '__all__'

class BookingSerializer(serializers.ModelSerializer):

    class Meta:
        model = Booking
        fields = '__all__'

class EventSerializer(serializers.ModelSerializer):

    class Meta:
        model = Event
        fields = '__all__'