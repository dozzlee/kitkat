from django.shortcuts import render,get_object_or_404, render_to_response

# Create your views here.
from .models import Event, Role, Address, Category, Profile, Ticket, Booking
from backend.forms import *
from django.http import HttpResponseRedirect,HttpResponse,JsonResponse
from django.urls import reverse
import datetime
from django.contrib.auth.decorators import permission_required
from backend.serializers import EventSerializer
import json as simplejson

def index(request):
        num_visits = request.session.get('num_visits', 0)
        request.session['num_visits'] = num_visits+1
        event_list = Event.objects.all()

        return render(request,'index.html',context={'event_list': event_list, 'num_visits': num_visits},)

def AdminEventList(request):
        event_list = Event.objects.prefetch_related('ticket_set').all()

        # If this is a POST request then process the Form data
        if request.method == 'POST':
                # Create a form instance and populate it with data from the request (binding):
                event_instance = get_object_or_404(Event, pk=request.POST.get('event_id', None))
                
                # Check if edit or delete for event post submit
                if request.POST.get('event_submit_type', None) == "event_delete":
                        form = EditEventForm()
                        event_instance.delete()
                elif request.POST.get('event_submit_type', None) == "event_edit":
                        form = EditEventForm(request.POST, instance=event_instance)

                        # Check if the form is valid:
                        if form.is_valid():
                                event_instance.save()
                                event_list = Event.objects.all()
                        else:
                                response = simplejson.dumps({"status": "Error", "request": request.POST})
                                return HttpResponse (response)
                elif request.POST.get('event_submit_type', None) == "event_alloc_ticket":
                        form = EditEventForm(request.POST, instance=event_instance)
                        form.save()
                elif request.POST.get('event_submit_type', None) == "event_ticket_update":
                        form = EditEventForm(request.POST, instance=event_instance)
                        ticket_instance = get_object_or_404(Ticket, pk=request.POST.get('ticket_id', None))
                        form.save(ticket=ticket_instance)
                        # form.add_error('quantity', 'Ticket qty value allocated is greater than event tickets available')
                elif request.POST.get('event_submit_type', None) == "event_ticket_delete":
                        form = EditEventForm()
                        ticket_instance = get_object_or_404(Ticket, pk=request.POST.get('ticket_id', None))
                        ticket_instance.delete()
                else:
                        response = simplejson.dumps({"status": "Error", "request": request.POST})
                        return HttpResponse (response)
        # If this is a GET (or any other method) create the default form
        else:
                form = EditEventForm()

        # Render the HTML template with the data in the context variable.
        return render(request, 'admin/event_list.html', context={'event_list': event_list, 'form': form},)

def AdminEventAdd(request):
        event_list = Event.objects.all()

        # If this is a POST request then process the Form data
        if request.method == 'POST':
                # Create a form instance and populate it with data from the request (binding):
                form = AddEventForm(request.POST)

                # Check if the form is valid:
                if form.is_valid():
                        event_instance = form.save()
        # If this is a GET (or any other method) create the default form
        else:
                form = AddEventForm()

        # Render the HTML template with the data in the context variable.
        return render(request, 'admin/event_add.html',context={'event_list': event_list, 'form': form},)

def AdminOrdersList(request):
        event_list = Event.objects.all()

        # If this is a POST request then process the Form data
        if request.method == 'POST':
                # Create a form instance and populate it with data from the request (binding):
                event_instance = get_object_or_404(Event, pk=request.POST.get('event_id', None))
                form = EditEventForm(request.POST, instance=event_instance)

                # Check if the form is valid:
                if form.is_valid():
                        event_instance.save()
                        event_list = Event.objects.all()
        # If this is a GET (or any other method) create the default form
        else:
                # proposed_renewal_date = datetime.date.today() + datetime.timedelta(weeks=3)
                # form = EditEventForm(initial={'end_time': proposed_renewal_date})
                form = EditEventForm()

        # Render the HTML template with the data in the context variable.
        return render(request, 'admin/event_booking.html',context={'event_list': event_list, 'form': form},)

def EventView(request, id):
        # event_list = get_object_or_404(Event, pk=id)
        event_list = Event.objects.prefetch_related('ticket_set').get(pk=id)

        return render(request,'events/event_view.html',context={'event': event_list},)