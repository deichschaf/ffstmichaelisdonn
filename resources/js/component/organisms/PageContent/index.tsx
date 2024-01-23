import React from 'react';
import { PageContentProps } from '../../../props/props';
import useDocumentTitle from '../../useHooks/useDocumentTitle';
import ErrorBoundary from '../errorboundary';
import ContentCalendar from './components/ContentCalendar';
import ContentContact from './components/ContentContact';
import ContentDownload from './components/ContentDownload';
import ContentEmergency from './components/ContentEmergency';
import ContentEmergencyArea from './components/ContentEmergencyArea';
import ContentEmergencyDetail from './components/ContentEmergencyDetail';
import ContentEmergencyFireRegister from './components/ContentEmergencyFireRegister';
import ContentEmergencyStatistic from './components/ContentEmergencyStatistic';
import ContentErrorPage from './components/ContentErrorPage';
import ContentFacebookTimeline from './components/ContentFacebookTimeline';
import ContentForm from './components/ContentForm';
import ContentGallery from './components/ContentGallery';
import ContentHeadline from './components/ContentHeadline';
import ContentImage from './components/ContentImage';
import ContentInstagramTimeline from './components/ContentInstagramTimeline';
import ContentLinks from './components/ContentLinks';
import ContentLinksLogo from './components/ContentLinksLogo';
import ContentList from './components/ContentList';
import ContentManagement from './components/ContentManagement';
import ContentNewsDetail from './components/ContentNewsDetail';
import ContentNewsFloDith from './components/ContentNewsFloDith';
import ContentNewsOverview from './components/ContentNewsOverview';
import ContentPageNotFound from './components/ContentPageNotFound';
import ContentScheduler from './components/ContentScheduler';
import ContentSitemap from './components/ContentSitemap';
import ContentStation from './components/ContentStation';
import ContentStationOverview from './components/ContentStationOverview';
import ContentTelephoneNumber from './components/ContentTelephoneNumber';
import ContentText from './components/ContentText';
import ContentTimetable from './components/ContentTimetable';
import ContentVehicle from './components/ContentVehicle';
import ContentVehicleDetail from './components/ContentVehicleDetail';
import ContentVehicleDetailFloDith from './components/ContentVehicleDetailFloDith';
import ContentVehicleSearch from './components/ContentVehicleSearch';

const PageContent: React.FC<React.PropsWithChildren<PageContentProps>> = (
  props: PageContentProps,
): JSX.Element => {
  if (typeof props.data === 'undefined') {
    return (
      <ErrorBoundary>
        <ContentPageNotFound data={props.data} />
      </ErrorBoundary>
    );
  }

  if (typeof props.data.title !== 'undefined') {
    useDocumentTitle(props.data.title);
  }

  return (
    <ErrorBoundary>
      {props.pagecontenttype !== 47 && props.pagecontenttype !== 48 ? (
        <ErrorBoundary>
          <ContentHeadline data={props.data} />
        </ErrorBoundary>
      ) : (
        <></>
      )}
      {props.pagecontenttype === -1 ? (
        <ErrorBoundary>
          <ContentErrorPage data={props.data} />
        </ErrorBoundary>
      ) : (
        <></>
      )}
      {props.pagecontenttype === 0 ? (
        <ErrorBoundary>
          <ContentPageNotFound data={props.data} />
        </ErrorBoundary>
      ) : (
        <></>
      )}
      {props.pagecontenttype === 1 ? (
        <ErrorBoundary>
          <ContentText data={props.data} />
        </ErrorBoundary>
      ) : (
        <></>
      )}
      {props.pagecontenttype === 2 ? (
        <ErrorBoundary>
          <ContentText data={props.data} />
          <ContentGallery data={props.data} />
        </ErrorBoundary>
      ) : (
        <></>
      )}
      {props.pagecontenttype === 3 ? (
        <ErrorBoundary>
          <ContentList data={props.data} />
          <ContentGallery data={props.data} />
        </ErrorBoundary>
      ) : (
        <></>
      )}
      {props.pagecontenttype === 4 ? (
        <ErrorBoundary>
          <ContentList data={props.data} />
        </ErrorBoundary>
      ) : (
        <></>
      )}
      {props.pagecontenttype === 5 ? (
        <ErrorBoundary>
          <ContentCalendar data={props.data} />
          <ContentText data={props.data} />
          <ContentGallery data={props.data} />
        </ErrorBoundary>
      ) : (
        <></>
      )}
      {props.pagecontenttype === 6 ? (
        <ErrorBoundary>
          <ContentCalendar data={props.data} />
          <ContentText data={props.data} />
          <ContentGallery data={props.data} />
          <ContentContact data={props.data} />
        </ErrorBoundary>
      ) : (
        <></>
      )}
      {props.pagecontenttype === 7 ? (
        <ErrorBoundary>
          <ContentLinks data={props.data} />
        </ErrorBoundary>
      ) : (
        <></>
      )}
      {props.pagecontenttype === 8 ? (
        <ErrorBoundary>
          <ContentLinksLogo data={props.data} />
        </ErrorBoundary>
      ) : (
        <></>
      )}
      {props.pagecontenttype === 9 ? (
        <ErrorBoundary>
          <ContentCalendar data={props.data} />
        </ErrorBoundary>
      ) : (
        <></>
      )}
      {props.pagecontenttype === 10 ? (
        <ErrorBoundary>
          <ContentContact data={props.data} />
        </ErrorBoundary>
      ) : (
        <></>
      )}
      {props.pagecontenttype === 11 ? (
        <ErrorBoundary>
          <ContentText data={props.data} />
          <ContentImage data={props.data} />
          <ContentGallery data={props.data} />
        </ErrorBoundary>
      ) : (
        <></>
      )}
      {props.pagecontenttype === 12 ? (
        <ErrorBoundary>
          <ContentFacebookTimeline data={props.data} />
        </ErrorBoundary>
      ) : (
        <></>
      )}
      {props.pagecontenttype === 13 ? (
        <ErrorBoundary>
          <ContentInstagramTimeline data={props.data} />
        </ErrorBoundary>
      ) : (
        <></>
      )}
      {props.pagecontenttype === 14 ? (
        <ErrorBoundary>
          <ContentText data={props.data} />
          <ContentGallery data={props.data} />
          <ContentForm data={props.data} />
        </ErrorBoundary>
      ) : (
        <></>
      )}
      {props.pagecontenttype === 15 ? (
        <ErrorBoundary>
          <ContentGallery data={props.data} />
        </ErrorBoundary>
      ) : (
        <></>
      )}
      {props.pagecontenttype === 16 ? (
        <ErrorBoundary>
          <ContentText data={props.data} />
          <ContentDownload data={props.data} />
        </ErrorBoundary>
      ) : (
        <></>
      )}
      {props.pagecontenttype === 17 ? (
        <ErrorBoundary>
          <ContentText data={props.data} />
          <ContentDownload data={props.data} />
          <ContentGallery data={props.data} />
        </ErrorBoundary>
      ) : (
        <></>
      )}
      {props.pagecontenttype === 18 ? (
        <ErrorBoundary>
          <ContentList data={props.data} />
          <ContentDownload data={props.data} />
        </ErrorBoundary>
      ) : (
        <></>
      )}
      {props.pagecontenttype === 19 ? (
        <ErrorBoundary>
          <ContentList data={props.data} />
          <ContentDownload data={props.data} />
          <ContentGallery data={props.data} />
        </ErrorBoundary>
      ) : (
        <></>
      )}
      {props.pagecontenttype === 20 ? (
        <ErrorBoundary>
          <ContentManagement data={props.data} />
        </ErrorBoundary>
      ) : (
        <></>
      )}
      {props.pagecontenttype === 21 ? (
        <ErrorBoundary>
          <ContentManagement data={props.data} />
          <ContentGallery data={props.data} />
        </ErrorBoundary>
      ) : (
        <></>
      )}
      {props.pagecontenttype === 22 ? (
        <ErrorBoundary>
          <ContentText data={props.data} />
          <ContentManagement data={props.data} />
        </ErrorBoundary>
      ) : (
        <></>
      )}
      {props.pagecontenttype === 23 ? (
        <ErrorBoundary>
          <ContentDownload data={props.data} />
        </ErrorBoundary>
      ) : (
        <></>
      )}
      {props.pagecontenttype === 24 ? (
        <ErrorBoundary>
          <ContentTimetable data={props.data} />
        </ErrorBoundary>
      ) : (
        <></>
      )}
      {props.pagecontenttype === 25 ? (
        <ErrorBoundary>
          <ContentText data={props.data} />
          <ContentTimetable data={props.data} />
        </ErrorBoundary>
      ) : (
        <></>
      )}
      {props.pagecontenttype === 26 ? (
        <ErrorBoundary>
          <ContentEmergency data={props.data} params={props.params} />
        </ErrorBoundary>
      ) : (
        <></>
      )}
      {props.pagecontenttype === 27 ? (
        <ErrorBoundary>
          <ContentText data={props.data} />
          <ContentEmergency data={props.data} params={props.params} />
        </ErrorBoundary>
      ) : (
        <></>
      )}
      {props.pagecontenttype === 28 ? (
        <ErrorBoundary>
          <ContentEmergencyDetail data={props.data} params={props.params} />
        </ErrorBoundary>
      ) : (
        <></>
      )}
      {props.pagecontenttype === 29 ? (
        <ErrorBoundary>
          <ContentVehicle data={props.data} />
        </ErrorBoundary>
      ) : (
        <></>
      )}
      {props.pagecontenttype === 30 ? (
        <ErrorBoundary>
          <ContentText data={props.data} />
          <ContentVehicle data={props.data} />
        </ErrorBoundary>
      ) : (
        <></>
      )}
      {props.pagecontenttype === 31 ? (
        <ErrorBoundary>
          <ContentVehicleDetail data={props.data} params={props.params} />
        </ErrorBoundary>
      ) : (
        <></>
      )}
      {props.pagecontenttype === 32 ? (
        <ErrorBoundary>
          <ContentSitemap data={props.data} params={props.params} />
        </ErrorBoundary>
      ) : (
        <></>
      )}
      {props.pagecontenttype === 33 ? (
        <ErrorBoundary>
          <ContentText data={props.data} />
          <ContentSitemap data={props.data} params={props.params} />
        </ErrorBoundary>
      ) : (
        <></>
      )}
      {props.pagecontenttype === 34 ? (
        <ErrorBoundary>
          <ContentScheduler data={props.data} params={props.params} />
        </ErrorBoundary>
      ) : (
        <></>
      )}
      {props.pagecontenttype === 35 ? (
        <ErrorBoundary>
          <ContentText data={props.data} />
          <ContentScheduler data={props.data} params={props.params} />
        </ErrorBoundary>
      ) : (
        <></>
      )}
      {props.pagecontenttype === 36 ? (
        <ErrorBoundary>
          <ContentNewsOverview data={props.data} params={props.params} />
        </ErrorBoundary>
      ) : (
        <></>
      )}
      {props.pagecontenttype === 37 ? (
        <ErrorBoundary>
          <ContentText data={props.data} />
          <ContentNewsOverview data={props.data} params={props.params} />
        </ErrorBoundary>
      ) : (
        <></>
      )}
      {props.pagecontenttype === 38 ? (
        <ErrorBoundary>
          <ContentNewsDetail data={props.data} params={props.params} />
        </ErrorBoundary>
      ) : (
        <></>
      )}
      {props.pagecontenttype === 39 ? (
        <ErrorBoundary>
          <ContentText data={props.data} />
          <ContentNewsDetail data={props.data} params={props.params} />
        </ErrorBoundary>
      ) : (
        <></>
      )}
      {props.pagecontenttype === 40 ? (
        <ErrorBoundary>
          <ContentEmergencyStatistic data={props.data} params={props.params} />
        </ErrorBoundary>
      ) : (
        <></>
      )}
      {props.pagecontenttype === 41 ? (
        <ErrorBoundary>
          <ContentEmergencyArea data={props.data} params={props.params} />
        </ErrorBoundary>
      ) : (
        <></>
      )}
      {props.pagecontenttype === 42 ? (
        <ErrorBoundary>
          <ContentEmergencyFireRegister data={props.data} params={props.params} />
        </ErrorBoundary>
      ) : (
        <></>
      )}
      {props.pagecontenttype === 43 ? (
        <ErrorBoundary>
          <ContentEmergencyFireRegister data={props.data} params={props.params} />
          <ContentDownload data={props.data} />
        </ErrorBoundary>
      ) : (
        <></>
      )}
      {props.pagecontenttype === 44 ? (
        <ErrorBoundary>
          <ContentTelephoneNumber data={props.data} params={props.params} />
        </ErrorBoundary>
      ) : (
        <></>
      )}
      {
        // 45 Redirect
      }
      {props.pagecontenttype === 46 ? (
        <ErrorBoundary>
          <ContentStationOverview data={props.data} params={props.params} />
        </ErrorBoundary>
      ) : (
        <></>
      )}
      {props.pagecontenttype === 47 ? (
        <ErrorBoundary>
          <ContentStation data={props.data} params={props.params} />
        </ErrorBoundary>
      ) : (
        <></>
      )}
      {props.pagecontenttype === 48 ? (
        <ErrorBoundary>
          <ContentVehicleDetailFloDith data={props.data} params={props.params} />
        </ErrorBoundary>
      ) : (
        <></>
      )}
      {props.pagecontenttype === 49 ? (
        <ErrorBoundary>
          <ContentNewsFloDith data={props.data} params={props.params} />
        </ErrorBoundary>
      ) : (
        <></>
      )}
      {props.pagecontenttype === 50 ? (
        <ErrorBoundary>
          <ContentVehicleSearch data={props.data} params={props.params} />
        </ErrorBoundary>
      ) : (
        <></>
      )}
    </ErrorBoundary>
  );
};
export default PageContent;
