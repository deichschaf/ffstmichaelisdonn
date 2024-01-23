import React from 'react';
import { Col, Row } from 'react-bootstrap';
import { ContentManagementProps } from '../../../../../props/props';
import GridSimple from '../../../../molecules/GridSimple';
import ErrorBoundary from '../../../errorboundary';
import ManagementFull from './components/ManagementFull';
import ManagementSmall from './components/ManagementSmall';

const ContentManagement: React.FC<React.PropsWithChildren<ContentManagementProps>> = (
  props: ContentManagementProps,
): JSX.Element => {
  if (typeof props.data === 'undefined') {
    return <></>;
  }
  if (typeof props.data.management === 'undefined') {
    return <></>;
  }
  return (
    <ErrorBoundary>
      <GridSimple>
        <Row>
          <Col xxl={1} xl={1} lg={1} md={1} sm={0} xs={0} />
          <Col xxl={4} xl={4} lg={4} md={4} sm={12} xs={12}>
            <ManagementFull data={props.data.management} funktionIds={[1, 2]} />
          </Col>
          <Col xxl={1} xl={1} lg={1} md={1} sm={0} xs={0} />
          <Col xxl={1} xl={1} lg={1} md={1} sm={0} xs={0} />
          <Col xxl={4} xl={4} lg={4} md={4} sm={12} xs={12}>
            <ManagementFull data={props.data.management} funktionIds={[3, 4]} />
          </Col>
          <Col xxl={1} xl={1} lg={1} md={1} sm={0} xs={0} />
        </Row>
        <Row>
          <Col xxl={4} xl={4} lg={4} md={4} sm={12} xs={12}>
            <ManagementSmall data={props.data.management} funktionIds={[5, 6]} />
          </Col>
          <Col xxl={1} xl={1} lg={1} md={1} sm={0} xs={0} />
          <Col xxl={1} xl={1} lg={1} md={1} sm={0} xs={0} />
          <Col xxl={1} xl={1} lg={1} md={1} sm={0} xs={0} />
          <Col xxl={1} xl={1} lg={1} md={1} sm={0} xs={0} />
          <Col xxl={4} xl={4} lg={4} md={4} sm={12} xs={12}>
            <ManagementSmall data={props.data.management} funktionIds={[7, 8]} />
          </Col>
        </Row>
        <Row>
          <Col xxl={4} xl={4} lg={4} md={4} sm={12} xs={12}>
            <ManagementSmall data={props.data.management} funktionIds={[11, 12]} />
          </Col>
          <Col xxl={4} xl={4} lg={4} md={4} sm={12} xs={12}>
            <ManagementSmall data={props.data.management} funktionIds={[13, 14]} />
          </Col>
          <Col xxl={4} xl={4} lg={4} md={4} sm={12} xs={12}>
            <ManagementSmall data={props.data.management} funktionIds={[15, 16]} />
          </Col>
        </Row>
        <Row>
          <Col xxl={4} xl={4} lg={4} md={4} sm={12} xs={12}>
            <ManagementSmall data={props.data.management} funktionIds={[17, 18]} />
          </Col>
          <Col xxl={4} xl={4} lg={4} md={4} sm={12} xs={12}>
            <ManagementSmall data={props.data.management} funktionIds={[21, 22]} />
          </Col>
          <Col xxl={4} xl={4} lg={4} md={4} sm={0} xs={0} />
        </Row>
        <Row>
          <Col xxl={4} xl={4} lg={4} md={4} sm={12} xs={12}>
            <ManagementSmall data={props.data.management} funktionIds={[23, 24]} />
          </Col>
          <Col xxl={4} xl={4} lg={4} md={4} sm={12} xs={12}>
            <ManagementSmall data={props.data.management} funktionIds={[25]} />
          </Col>
          <Col xxl={4} xl={4} lg={4} md={4} sm={12} xs={12}>
            <ManagementSmall data={props.data.management} funktionIds={[26, 27]} />
          </Col>
        </Row>
        <Row>
          <Col xxl={4} xl={4} lg={4} md={4} sm={12} xs={12}>
            <ManagementSmall data={props.data.management} funktionIds={[28]} />
          </Col>
          <Col xxl={4} xl={4} lg={4} md={4} sm={0} xs={0} />
          <Col xxl={4} xl={4} lg={4} md={4} sm={12} xs={12}>
            <ManagementSmall data={props.data.management} funktionIds={[29]} />
          </Col>
        </Row>
      </GridSimple>
    </ErrorBoundary>
  );
};
export default ContentManagement;
