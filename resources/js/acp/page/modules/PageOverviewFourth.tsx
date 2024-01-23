import React from 'react';
import { Col, Row } from 'react-bootstrap';
import ErrorBoundary from '../../../component/organisms/errorboundary';
import { PageOverviewRootProps } from '../../../props/props';
import { deletePageLink, editHeadlinePageLink, editPageLink, isActive } from '../../helper';
import PageContentType from './PageContentType';

const PageOverviewFourth: React.FC<React.PropsWithChildren<PageOverviewRootProps>> = (
  props: PageOverviewRootProps,
): JSX.Element => (
  <ErrorBoundary>
    <Row>
      <Col xxl={3} xl={3} lg={3} md={3} sm={3} xs={3} />
      <Col xxl={5} xl={5} lg={5} md={5} sm={5} xs={5}>
        {props.page.title}
      </Col>
      <Col xxl={1} xl={1} lg={1} md={1} sm={1} xs={1}>
        <PageContentType
          contentTypeId={props.page.seiten_content_type}
          contentType={props.page.pagecontenttype}
          pagecontenttypes={props.pagecontenttypes}
        />
      </Col>
      <Col xxl={1} xl={1} lg={1} md={1} sm={1} xs={1}>
        {isActive(props.page.aktiv)}
      </Col>
      <Col xxl={1} xl={1} lg={1} md={1} sm={1} xs={1}>
        {props.upages.length === 0 && props.page.systempage ? (
          <>{deletePageLink(props.page.id, props.deletepath)}</>
        ) : (
          <></>
        )}
      </Col>
      <Col xxl={1} xl={1} lg={1} md={1} sm={1} xs={1}>
        {props.upages.length === 0 ? (
          <>{editPageLink(props.page.id, props.editpath)}</>
        ) : (
          <>{editHeadlinePageLink(props.page.id, props.editheadlinepath)}</>
        )}
      </Col>
    </Row>
  </ErrorBoundary>
);
export default PageOverviewFourth;
