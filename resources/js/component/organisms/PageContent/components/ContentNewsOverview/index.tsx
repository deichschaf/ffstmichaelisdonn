import React from 'react';
import { Col, Row } from 'react-bootstrap';
import { ContentNewsOverviewProps } from '../../../../../props/props';
import GridSimple from '../../../../molecules/GridSimple';
import ErrorBoundary from '../../../errorboundary';

const ContentNewsOverview: React.FC<React.PropsWithChildren<ContentNewsOverviewProps>> = (
  props: ContentNewsOverviewProps,
): JSX.Element => {
  if (typeof props.data === 'undefined') {
    return <></>;
  }
  if (typeof props.data.news === 'undefined') {
    return <></>;
  }
  return (
    <ErrorBoundary>
      {props.data.news.map((item, idx) => (
        <Row key={idx} className="colorchanger">
          <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
            <GridSimple>
              <Row>
                <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
                  {item.date_time}
                </Col>
              </Row>
              <Row>
                <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
                  {item.title}
                  {item.subtitle !== '' ? (
                    <>
                      <br />
                      <small>{item.subtitle}</small>
                    </>
                  ) : (
                    <></>
                  )}
                </Col>
              </Row>
              <Row>
                <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
                  <div dangerouslySetInnerHTML={{ __html: item.article }} />
                </Col>
              </Row>
            </GridSimple>
          </Col>
        </Row>
      ))}
    </ErrorBoundary>
  );
};
export default ContentNewsOverview;
