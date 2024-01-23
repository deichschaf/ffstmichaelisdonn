import React from 'react';
import { Col, Row } from 'react-bootstrap';
import { ContentSitemapProps } from '../../../../../props/props';
import ErrorBoundary from '../../../errorboundary';
import { Link } from 'react-router-dom';

const ContentSitemap: React.FC<React.PropsWithChildren<ContentSitemapProps>> = (
  props: ContentSitemapProps
): JSX.Element => {
  if (typeof props.data === 'undefined') {
    return <></>;
  }
  if (typeof props.data.sitemap === 'undefined') {
    return <></>;
  }

  function buildLink(data) {
    if (data.target === '_blank') {
      return (
        <a href={data.url} target={data.target}>
          {data.title}
        </a>
      );
    }
    return <Link to={data.url}>{data.title}</Link>;
  }

  function checkSubSites(datas) {
    if (datas.lenght === 0) {
      return <></>;
    }
    // eslint-disable-next-line @typescript-eslint/no-use-before-define
    return <ul>{datas.map((item, idx) => buildLis(item, idx))}</ul>;
  }

  function buildLis(item, idx) {
    return (
      <li key={idx}>
        {buildLink(item)}
        {checkSubSites(item.upages)}
      </li>
    );
  }

  return (
    <ErrorBoundary>
      <Row>
        <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
          <ul className="sitemap">{props.data.sitemap.map((item, idx) => buildLis(item, idx))}</ul>
        </Col>
      </Row>
    </ErrorBoundary>
  );
};
export default ContentSitemap;
