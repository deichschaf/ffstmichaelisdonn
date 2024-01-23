import React from 'react';
import { Col, Row } from 'react-bootstrap';
import { ContentLinksProps } from '../../../../../props/props';
import ErrorBoundary from '../../../errorboundary';
import { Link } from 'react-router-dom';

const ContentLinks: React.FC<React.PropsWithChildren<ContentLinksProps>> = (
  props: ContentLinksProps
): JSX.Element => {
  if (typeof props.data === 'undefined') {
    return <></>;
  }
  if (typeof props.data.links === 'undefined') {
    return <></>;
  }

  function buildLinkList(data, idx) {
    if (typeof data.category_title !== 'undefined') {
      return (
        <Row key={idx}>
          <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
            {data.category_title}
          </Col>
        </Row>
      );
    }
    return (
      <Row key={idx} className="colorchanger">
        <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
          {data.target === '_blank' ? (
            <a href={data.url} target={data.target} rel={data.rel}>
              {data.title}
            </a>
          ) : (
            <Link to={data.url}>{data.title}</Link>
          )}
          {data.description !== '' && data.description !== null ? (
            <>
              <br />
              {data.description}
            </>
          ) : (
            <></>
          )}
        </Col>
      </Row>
    );
  }

  return (
    <ErrorBoundary>
      <Row>
        <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
          {props.data.links.map((data, idx) => buildLinkList(data, idx))}
        </Col>
      </Row>
    </ErrorBoundary>
  );
};
export default ContentLinks;
