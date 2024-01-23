import React from 'react';
import { Col, Row } from 'react-bootstrap';
import ErrorBoundary from '../../../component/organisms/errorboundary';
import { PageOverviewRootProps } from '../../../props/props';
import { deletePageLink, editHeadlinePageLink, editPageLink, isActive } from '../../helper';
import PageContentType from './PageContentType';
import PageOverviewFourthList from './PageOverviewFourthList';

const PageOverviewThirt: React.FC<React.PropsWithChildren<PageOverviewRootProps>> = (
  props: PageOverviewRootProps,
): JSX.Element => (
  <ErrorBoundary>
    <Row>
      <Col xxl={2} xl={2} lg={2} md={2} sm={2} xs={2} />
      <Col xxl={6} xl={6} lg={6} md={6} sm={6} xs={6}>
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
    {props.upages.length > 0 ? (
      <PageOverviewFourthList
        upages={props.upages}
        deletepath={props.deletepath}
        editpath={props.editpath}
        editheadlinepath={props.editheadlinepath}
        pagecontenttypes={props.pagecontenttypes}
      />
    ) : (
      <></>
    )}
  </ErrorBoundary>
);
export default PageOverviewThirt;
