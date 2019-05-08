from backend.models import Event
from backend.serializers import EventSerializer
from rest_framework import viewsets


class EventViewSet(viewsets.ModelViewSet):
    """
    retrieve:
        Return a event instance.

    list:
        Return all event, ordered by most recently joined.

    create:
        Create a new event.

    delete:
        Remove an existing event.

    partial_update:
        Update one or more fields on an existing event.

    update:
        Update a event.
    """
    queryset = Event.objects.all()
    serializer_class = EventSerializer