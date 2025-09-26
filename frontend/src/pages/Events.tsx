import React from 'react';
import { Helmet } from 'react-helmet-async';
import { useTranslation } from 'react-i18next';
import { useUpcomingEvents, usePastEvents } from '../hooks/useEvents';
import LoadingSpinner from '../components/ui/LoadingSpinner';

const Events: React.FC = () => {
  const { t } = useTranslation();
  const { events: upcomingEvents, loading: upcomingLoading, error: upcomingError } = useUpcomingEvents();
  const { events: pastEvents, loading: pastLoading, error: pastError } = usePastEvents();

  return (
    <>
      <Helmet>
        <title>Events - Rust Cameroon | Meetups, Workshops & Community Events</title>
        <meta 
          name="description" 
          content="Join Rust Cameroon events, meetups, and workshops. Learn Rust programming and connect with the community. Find upcoming events, workshops, and networking opportunities." 
        />
        <meta name="keywords" content="rust events, rust meetups, rust workshops, programming events cameroon, tech community events, rust community, software development events" />
        <link rel="canonical" href="https://rustcameroon.com/events" />
        
        {/* Open Graph */}
        <meta property="og:title" content="Events - Rust Cameroon | Meetups, Workshops & Community Events" />
        <meta property="og:description" content="Join Rust Cameroon events, meetups, and workshops. Learn Rust programming and connect with the community." />
        <meta property="og:url" content="https://rustcameroon.com/events" />
        <meta property="og:type" content="website" />
        
        {/* Twitter */}
        <meta name="twitter:title" content="Events - Rust Cameroon | Meetups, Workshops & Community Events" />
        <meta name="twitter:description" content="Join Rust Cameroon events, meetups, and workshops. Learn Rust programming and connect with the community." />
        
        {/* Structured Data */}
        <script type="application/ld+json">
        {JSON.stringify({
          "@context": "https://schema.org",
          "@type": "Event",
          "name": "Rust Cameroon Community Events",
          "description": "Join Rust Cameroon events, meetups, and workshops. Learn Rust programming and connect with the community.",
          "url": "https://rustcameroon.com/events",
          "organizer": {
            "@type": "Organization",
            "name": "Rust Cameroon",
            "url": "https://rustcameroon.com"
          },
          "eventStatus": "https://schema.org/EventScheduled",
          "eventAttendanceMode": "https://schema.org/OfflineEventAttendanceMode",
          "location": {
            "@type": "Place",
            "name": "Cameroon",
            "address": {
              "@type": "PostalAddress",
              "addressCountry": "CM"
            }
          }
        })}
        </script>
      </Helmet>

      <div className="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div className="text-center mb-12">
          <h1 className="text-4xl md:text-5xl font-bold text-gray-900 dark:text-white mb-6">
            {t('events.title')}
          </h1>
          <p className="text-xl text-gray-600 dark:text-gray-400 max-w-3xl mx-auto">
            {t('events.subtitle')}
          </p>
        </div>

        {/* Upcoming Events */}
        <section className="mb-16">
          <h2 className="text-3xl font-bold text-gray-900 dark:text-white mb-8">
            {t('events.upcoming')}
          </h2>
          
          {upcomingLoading ? (
            <LoadingSpinner size="lg" text={t('common.loading')} />
          ) : upcomingError ? (
            <div className="text-center py-12">
              <div className="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-6 max-w-md mx-auto">
                <svg className="w-12 h-12 text-red-600 dark:text-red-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <h3 className="text-lg font-medium text-red-800 dark:text-red-200 mb-2">
                  {t('common.error')}
                </h3>
                <p className="text-red-600 dark:text-red-400">
                  {upcomingError}
                </p>
              </div>
            </div>
          ) : upcomingEvents.length > 0 ? (
            <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
              {upcomingEvents.map((event) => (
                <div key={event.id} className="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden">
                  <div className="p-6">
                    <div className="flex items-center justify-between mb-4">
                      <span className="px-3 py-1 bg-orange-100 dark:bg-orange-900/20 text-orange-600 dark:text-orange-400 text-sm font-medium rounded-full">
                        {event.event_type}
                      </span>
                      <span className="text-sm text-gray-500 dark:text-gray-400">
                        {new Date(event.date).toLocaleDateString()}
                      </span>
                    </div>
                    
                    <h3 className="text-xl font-semibold text-gray-900 dark:text-white mb-3">
                      {event.title}
                    </h3>
                    
                    <p className="text-gray-600 dark:text-gray-400 mb-4">
                      {event.description}
                    </p>
                    
                    <div className="space-y-2 text-sm text-gray-500 dark:text-gray-400">
                      <div className="flex items-center">
                        <svg className="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {event.time}
                      </div>
                      <div className="flex items-center">
                        <svg className="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                          <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        {event.location}
                      </div>
                    </div>
                    
                    <button className="w-full mt-4 bg-orange-600 hover:bg-orange-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                      {t('events.register')}
                    </button>
                  </div>
                </div>
              ))}
            </div>
          ) : (
            <div className="text-center py-12 bg-white dark:bg-gray-800 rounded-lg shadow-lg">
              <svg className="w-16 h-16 text-gray-400 dark:text-gray-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
              </svg>
              <h3 className="text-lg font-medium text-gray-900 dark:text-white mb-2">
                {t('events.noUpcomingEvents')}
              </h3>
              <p className="text-gray-600 dark:text-gray-400">
                {t('events.noUpcomingEventsDescription')}
              </p>
            </div>
          )}
        </section>

        {/* Past Events */}
        <section>
          <h2 className="text-3xl font-bold text-gray-900 dark:text-white mb-8">
            {t('events.past')}
          </h2>
          
          {pastLoading ? (
            <LoadingSpinner size="lg" text={t('common.loading')} />
          ) : pastError ? (
            <div className="text-center py-12">
              <div className="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-6 max-w-md mx-auto">
                <svg className="w-12 h-12 text-red-600 dark:text-red-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <h3 className="text-lg font-medium text-red-800 dark:text-red-200 mb-2">
                  {t('common.error')}
                </h3>
                <p className="text-red-600 dark:text-red-400">
                  {pastError}
                </p>
              </div>
            </div>
          ) : pastEvents.length > 0 ? (
            <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
              {pastEvents.map((event) => (
                <div key={event.id} className="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden opacity-75">
                  <div className="p-6">
                    <div className="flex items-center justify-between mb-4">
                      <span className="px-3 py-1 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400 text-sm font-medium rounded-full">
                        {event.event_type}
                      </span>
                      <span className="text-sm text-gray-500 dark:text-gray-400">
                        {new Date(event.date).toLocaleDateString()}
                      </span>
                    </div>
                    
                    <h3 className="text-xl font-semibold text-gray-900 dark:text-white mb-3">
                      {event.title}
                    </h3>
                    
                    <p className="text-gray-600 dark:text-gray-400 mb-4">
                      {event.description}
                    </p>
                    
                    <div className="space-y-2 text-sm text-gray-500 dark:text-gray-400">
                      <div className="flex items-center">
                        <svg className="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {event.time}
                      </div>
                      <div className="flex items-center">
                        <svg className="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                          <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        {event.location}
                      </div>
                    </div>
                  </div>
                </div>
              ))}
            </div>
          ) : (
            <div className="text-center py-12 bg-white dark:bg-gray-800 rounded-lg shadow-lg">
              <p className="text-gray-600 dark:text-gray-400">
                {t('events.noPastEvents')}
              </p>
            </div>
          )}
        </section>

        {/* Call to Action */}
        <section className="mt-16 text-center">
          <div className="bg-gradient-to-r from-orange-600 to-red-600 rounded-lg p-8 text-white">
            <h2 className="text-2xl font-bold mb-4">
              {t('events.organizeEvent.title')}
            </h2>
            <p className="text-lg mb-6 opacity-90">
              {t('events.organizeEvent.description')}
            </p>
            <a
              href="mailto:inforustcameroon@gmail.com"
              className="bg-white text-orange-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors inline-block"
            >
              {t('events.organizeEvent.contactUs')}
            </a>
          </div>
        </section>
      </div>
    </>
  );
};

export default Events;
