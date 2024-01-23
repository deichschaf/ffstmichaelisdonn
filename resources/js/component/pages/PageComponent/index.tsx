import React, { useEffect, useState } from 'react';
import { Col, Row } from 'react-bootstrap';
import { PageComponentProps } from '../../../props/props';
import H1 from '../../atoms/Typography/H1';
import { getCookie, getCSRFToken } from '../../component_helper';
import LoadingAlertBox from '../../molecules/LoadingAlertBox';

const PageComponent: React.FC<React.PropsWithChildren<PageComponentProps>> = (
  props: PageComponentProps
): JSX.Element => {
  const [loading, setLoading] = useState(true);
  const [pageContent, setPageContent] = useState<any>(null);
  useEffect(() => {
    async function fetchMyApi() {
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
        let response = await fetch('/api/get/page', {
          method: 'POST',
          headers,
          body: JSON.stringify({
            page: props.page,
            'csrf-token': token,
            _token: token,
          }),
        });
        response = await response.json();
        setPageContent(response);
        setLoading(false);
      } catch (error) {
        if (window.location.pathname !== '/login') {
          window.location.reload();
        }
      }
    }

    fetchMyApi();
  });

  if (loading || pageContent === null) {
    return <LoadingAlertBox />;
  }
  return (
    <>
      {pageContent.headline !== null ? (
        <Row>
          <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
            <H1 label={pageContent.headline} />
          </Col>
        </Row>
      ) : (
        <></>
      )}
      {pageContent.content !== null ? (
        <Row>
          <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
            {pageContent.content}
          </Col>
        </Row>
      ) : (
        <></>
      )}
    </>
  );
};
export default PageComponent;
