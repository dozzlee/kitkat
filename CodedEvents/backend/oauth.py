# # from django.shortcuts import render
from rest_framework.response import Response
from rest_framework.decorators import api_view, permission_classes, schema
from rest_framework.permissions import AllowAny
import requests
from django.urls import path
from django.conf.urls import url
from .serializers import ProfileCreateSerializer
import coreapi, coreschema
from rest_framework.schemas import AutoSchema, ManualSchema

CLIENT_ID = 'eJfDFgNfLvzhPVICLal1362UR5JLoMHnM1JxCHbY'
CLIENT_SECRET = 'q1DtL4jU2wKMRIh9FHsBgu7kLhI0B2pALUwGwpeXsV9KgmsD4C5qObznYxKFWbuwVHpJdHseXJgRIKyhryX8d2OXt0Nho8baWeeLfOCWuoFoqF7hEaL0hR6pMikuyCoB'

# # Create your views here.
@api_view(['POST'])
@permission_classes([AllowAny])
@schema(AutoSchema(manual_fields=[
    coreapi.Field("email", required=True, location="form", type="string", description="Username of end user"),
    coreapi.Field("password", required=True, location="form", type="string", description="Password of end user"),
]))
def register(request):
    '''
    Registers user to the server
    '''
    # Put the data from the request into the serializer 
    serializer = ProfileCreateSerializer(data=request.data) 
    # Validate the data
    if serializer.is_valid():
        # If it is valid, save the data (creates a user).
        serializer.save() 
        # Then we get a token for the created user.
        # This could be done differentley 
        r = requests.post('http://localhost:8080/o/token/', 
            data={
                'grant_type': 'password',
                'username': request.data['email'],
                'password': request.data['password'],
                'client_id': CLIENT_ID,
                'client_secret': CLIENT_SECRET,
            },
        )
        return Response(r.json())
        # return Response(r)
    return Response(serializer.errors)

@api_view(['POST'])
@permission_classes([AllowAny])
@schema(AutoSchema(manual_fields=[
    coreapi.Field("email", required=True, location="form", type="string", description="Username of end user"),
    coreapi.Field("password", required=True, location="form", type="string", description="Password of end user"),
]))
def token(request):
    '''
    Gets tokens with username and password
    '''
    r = requests.post(
    'http://localhost:8080/o/token/', 
        data={
            'grant_type': 'password',
            'username': request.data['email'],
            'password': request.data['password'],
            'client_id': CLIENT_ID,
            'client_secret': CLIENT_SECRET,
        },
    )
    return Response(r.json())

@api_view(['POST'])
@permission_classes([AllowAny])
@schema(AutoSchema(manual_fields=[
    coreapi.Field("refresh_token", required=True, location="form", type="string", description="Token to refresh"),
]))
def refresh_token(request):
    '''
    Assigns new user access token
    '''
    r = requests.post(
    'http://localhost:8080/o/token/', 
        data={
            'grant_type': 'refresh_token',
            'refresh_token': request.data['refresh_token'],
            'client_id': CLIENT_ID,
            'client_secret': CLIENT_SECRET,
        },
    )
    return Response(r.json())

@api_view(['POST'])
@permission_classes([AllowAny])
@schema(AutoSchema(manual_fields=[
    coreapi.Field("token", required=True, location="form", type="string", description="Token to revoke"),
]))
def revoke_token(request):
    """
    Method to revoke tokens
    """
    r = requests.post(
        'http://localhost:8080/o/revoke_token/', 
        data={
            'token': request.data['token'],
            'client_id': CLIENT_ID,
            'client_secret': CLIENT_SECRET,
        },
    )
    # If it goes well return sucess message (would be empty otherwise) 
    if r.status_code == requests.codes.ok:
        return Response({'message': 'token revoked'}, r.status_code)
    # Return the error if it goes badly
    return Response(r.json(), r.status_code)

urlpatterns = [
    # url(r'^register', register),
    # url(r'^token', token),
    # url(r'^token/refresh/', refresh_token),
    # url(r'^token/revoke/', revoke_token),
    path('register/', register),
    path('token/', token),
    path('token/refresh/', refresh_token),
    path('token/revoke/', revoke_token),
]