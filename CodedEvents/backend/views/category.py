from backend.models import Category
from backend.serializers import CategorySerializer
from rest_framework import viewsets


class CategoryViewSet(viewsets.ModelViewSet):
    """
    retrieve:
        Return a category instance.

    list:
        Return all category, ordered by most recently joined.

    create:
        Create a new category.

    delete:
        Remove an existing category.

    partial_update:
        Update one or more fields on an existing category.

    update:
        Update a category.
    """
    queryset = Category.objects.all()
    serializer_class = CategorySerializer