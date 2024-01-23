import React from 'react';
import { Col } from 'react-bootstrap';
import { NewsTruckCardProps } from '../../../props/props';
import Link from '../../atoms/Link';
import PictureSourcSet from '../../atoms/Picture/SourceSet';
import ErrorBoundary from '../../organisms/errorboundary';

const NewsTruckCard: React.FC<React.PropsWithChildren<NewsTruckCardProps>> = (
  props: NewsTruckCardProps,
): JSX.Element => {
  if (typeof props.data === 'undefined') {
    return <></>;
  }
  if (typeof props.data.id === 'undefined') {
    return <></>;
  }

  if (typeof props.data.img === 'undefined') {
    return <></>;
  }
  return (
    <ErrorBoundary>
      <Col xxl={4} xl={4} lg={4} md={4} sm={4} xs={4}>
        <div className="card h-100">
          <h4 className="card-header">
            <Link href={props.data.href} title={props.data.title} />
          </h4>
          <div className="card-body">
            <p className="card-text">
              <Link href={props.data.href}>
                <PictureSourcSet
                  path={props.data.path}
                  img={props.data.img}
                  srcset={props.data.srcset}
                  alt={props.data.alt}
                  title={props.data.title}
                  className="button picture"
                />
              </Link>
            </p>
          </div>
          <div className="card-footer">
            <Link href={props.data.href}>
              <span dangerouslySetInnerHTML={{ __html: props.data.title_full }} />
            </Link>
          </div>
        </div>
      </Col>
    </ErrorBoundary>
  );
};
export default NewsTruckCard;
