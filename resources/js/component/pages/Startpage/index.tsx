import React, { useEffect, useState } from 'react';
import { useLocation } from 'react-router';
import Globalvars from '../../../globalvars';
import { StartPageProps } from '../../../props/props';
import DanceBall from '../../atoms/DanceBall';
import DireStraits from '../../atoms/DireStraits';
import HydrantCheckInfo from '../../atoms/HydrantCheckInfo';
import ReadyForUse from '../../atoms/ReadyForUse';
import RescueEliminateBailSave from '../../atoms/RescueEliminateBailSave';
import { getCookie, getCSRFToken } from '../../component_helper';
import GridSimple from '../../molecules/GridSimple';
import LoadingAlertBox from '../../molecules/LoadingAlertBox';
import ErrorBoundary from '../../organisms/errorboundary';
import PageContent from '../../organisms/PageContent';
import StatisticBoxArea from '../../organisms/StatisticBoxArea';

const Startpage: React.FC<React.PropsWithChildren<StartPageProps>> = (
  props: StartPageProps
): JSX.Element => {
  const [loading, setLoading] = useState(true);
  const [pageContent, setPageContent] = useState<any>(null);
  const location = useLocation();

  useEffect(() => {
    async function fetchMyApi() {
      const path = location;
      const token = getCSRFToken();
      // console.log(token);
      const csrfToken = getCookie('XSRF-TOKEN');
      let headers = new Headers({
        'Content-Type': 'application/json',
      });
      if (csrfToken !== null) {
        headers = new Headers({
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': csrfToken,
        });
      }
      try {
        let response = await fetch('/api/get/start', {
          method: 'POST',
          headers,
          body: JSON.stringify({
            path: path.pathname,
            'csrf-token': token,
            _token: token,
          }),
        });
        response = await response.json();
        setPageContent(response);
        setLoading(false);
      } catch (error) {
        window.location.reload();
      }
    }

    fetchMyApi();
  }, [location]);

  if (loading || pageContent === null) {
    return <LoadingAlertBox />;
  }

  return (
    <ErrorBoundary>
      <GridSimple>
        <PageContent data={pageContent.data} pagecontenttype={pageContent.pagecontenttype} />
      </GridSimple>
      {Globalvars.getIsFiredepartment() ? (
        <ErrorBoundary>
          {/* <NewsBoxes data={pageContent.data} /> */}
          {/* <PaulinchenTdbK/> */}
          <HydrantCheckInfo data={pageContent.data} />
          {/* <AnnualGeneralMeeting data={pageContent.data} /> */}
          <DanceBall data={pageContent.data} />
          <RescueEliminateBailSave />
          <ReadyForUse />
          <DireStraits />
          <StatisticBoxArea data={pageContent.data} />
        </ErrorBoundary>
      ) : (
        <></>
      )}
    </ErrorBoundary>
  );
};

export default Startpage;
