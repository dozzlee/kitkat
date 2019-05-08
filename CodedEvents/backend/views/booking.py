from backend.models import Booking
from backend.serializers import BookingSerializer
from rest_framework import viewsets


class BookingViewSet(viewsets.ModelViewSet):
    """
    retrieve:
        Return a booking instance.

    list:
        Return all booking, ordered by most recently joined.

    create:
        Create a new booking.

    delete:
        Remove an existing booking.

    partial_update:
        Update one or more fields on an existing booking.

    update:
        Update a booking.
    """
    queryset = Booking.objects.all()
    serializer_class = BookingSerializer