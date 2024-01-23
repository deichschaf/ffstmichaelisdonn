import React, { useEffect, useState } from 'react';
import { useLocation, useParams } from 'react-router';
import { PageProps } from '../../../props/props';
import { getCookie, getCSRFToken } from '../../component_helper';
import GridSimple from '../../molecules/GridSimple';
import LoadingAlertBox from '../../molecules/LoadingAlertBox';
import ErrorBoundary from '../../organisms/errorboundary';
import PageContent from '../../organisms/PageContent';

const Page: React.FC<React.PropsWithChildren<PageProps>> = (props: PageProps): JSX.Element => {
  const [loading, setLoading] = useState(true);
  const [pageContent, setPageContent] = useState<any>(null);

  const { slug, param1, param2, param3 } = useParams();
  const params = [] as any;
  params.push([{ slug }, { param1 }, { param2 }, { param3 }]);
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
      let url = `/api/get/${slug}`;
      if (param1 !== '' && param1 !== null && typeof param1 !== 'undefined') {
        url += `/${param1}`;
      }
      if (param2 !== '' && param2 !== null && typeof param2 !== 'undefined') {
        url += `/${param2}`;
      }
      if (param3 !== '' && param3 !== null && typeof param3 !== 'undefined') {
        url += `/${param3}`;
      }
      try {
        let response = await fetch(url, {
          method: 'POST',
          headers,
          body: JSON.stringify({
            'csrf-token': token,
            _token: token,
          }),
        });

        response = await response.json();
        setPageContent(response);
        setLoading(false);
      } catch (error) {
        // window.location.reload();
        console.log(error);
      }
    }
    fetchMyApi();
  }, [slug]);

  if (loading || pageContent === null) {
    return <LoadingAlertBox />;
  }

  return (
    <ErrorBoundary>
      <GridSimple>
        <PageContent
          data={pageContent.data}
          pagecontenttype={pageContent.pagecontenttype}
          params={params}
        />
      </GridSimple>
    </ErrorBoundary>
  );
};

export default Page;
