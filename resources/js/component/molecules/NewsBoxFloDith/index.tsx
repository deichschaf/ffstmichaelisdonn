import React from 'react';
import { Col, Row } from 'react-bootstrap';
import { NewsBoxFloDithProps } from '../../../props/props';
import MoreLink from '../../atoms/MoreLink';
import H3 from '../../atoms/Typography/H3';
import H4 from '../../atoms/Typography/H4';
import ErrorBoundary from '../../organisms/errorboundary';
import ContentArrayString from '../../organisms/PageContent/components/ContentArrayString';
import GridSimple from '../GridSimple';

const NewsBoxFloDith: React.FC<React.PropsWithChildren<NewsBoxFloDithProps>> = (
  props: NewsBoxFloDithProps,
): JSX.Element => {
  if (typeof props.data === 'undefined') {
    return <></>;
  }
  return (
    <ErrorBoundary>
      <GridSimple>
        <Row>
          <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
            <ContentArrayString content={props.data.created_at} />
          </Col>
        </Row>
        <Row>
          <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
            <H3 label={props.data.title} />
          </Col>
        </Row>
        {props.data.subtitle !== null && props.data.subtitle !== '' ? (
          <Row>
            <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
              <H4 label={props.data.subtitle} />
            </Col>
          </Row>
        ) : (
          <></>
        )}
        {props.data.article !== null && props.data.article !== '' ? (
          <Row>
            <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
              <ContentArrayString content={props.data.article} />
            </Col>
          </Row>
        ) : (
          <></>
        )}
        {props.data.link !== null && props.data.link !== '' ? (
          <Row>
            <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
              <MoreLink url={props.data.link} />
            </Col>
          </Row>
        ) : (
          <></>
        )}
      </GridSimple>
    </ErrorBoundary>
  );
};
export default NewsBoxFloDith;
