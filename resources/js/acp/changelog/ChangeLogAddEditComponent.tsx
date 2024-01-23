import React, { useEffect, useState } from 'react';
import { Col, Row } from 'react-bootstrap';
import { useParams } from 'react-router';
import Input from '../../component/atoms/Form/Input/Input';
import Addicon from '../../component/atoms/Icon/Admin/Addicon';
import Trashicon from '../../component/atoms/Icon/Admin/Trashicon';
import PageHeadline from '../../component/atoms/PageHeadline';
import { getCookie, getCSRFToken } from '../../component/component_helper';
import GridSimple from '../../component/molecules/GridSimple';
import LoadingAlertBox from '../../component/molecules/LoadingAlertBox';
import SaveInfoError from '../../component/molecules/SaveInfoError';
import SaveLine from '../../component/molecules/SaveLine';
import ErrorBoundary from '../../component/organisms/errorboundary';
import { ChangeLogAddEditProps } from '../../props/props';

const ChangeLogAddEditComponent: React.FC<ChangeLogAddEditProps> = (
  props: ChangeLogAddEditProps,
): JSX.Element => {
  const [loading, setLoading] = useState(true);
  const [getEditType, setEditType] = useState<string>('hinzufügen');
  const [errorText, setErrorText] = useState<any>(null);
  const [responseText, setResponseText] = useState<any>(null);
  const [getId, setId] = useState<number>(0);
  const [getRelease, setRelease] = useState<string>('');
  const [getDate, setDate] = useState<string>('');
  const [getChangelog, setChangelog] = useState<any>([]);
  const [getCountLogList, setCountLogList] = useState<any>({ maxcount: [] });

  const { id } = useParams();

  const AddNewItem = () => {
    setChangelog(getChangelog => [...getChangelog, `${getChangelog.length}`]);
    setCountLogList({ ...getCountLogList, maxcount: getChangelog });
  };

  function setDefault(data) {
    setId(data.id);
    setRelease(data.release);
    setDate(data.date);
    const changelog = [] as any;
    data.tasks.map((task, index) => changelog.push(task.value));
    setChangelog(changelog);
  }

  function CheckResponse(data) {
    if (data.success === true) {
      setResponseText('Erfolgreich gespeichert!');
    } else {
      setErrorText(data.errorMessage);
    }
  }

  function setCatchError(err) {
    setErrorText(err);
  }

  function handleIngredientRemove(id) {
    const newList = getChangelog.filter(changelog => changelog.id !== id);
    setChangelog(newList);
    setCountLogList({ ...getCountLogList, maxcount: getChangelog });
  }

  function onChangeValue(index, name, event) {
    const arr_title = `${name}_${index}`;
    const val = event.target.value;
    setChangelog({ ...getChangelog, [arr_title]: val });
  }

  const SubmitForm = event => {
    event.preventDefault();
    setErrorText(null);
    setResponseText(null);
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
    fetch('/api/admin/changelog/save', {
      method: 'POST',
      headers,
      body: JSON.stringify({
        id: getId,
        release: getRelease,
        date: getDate,
        'csrf-token': token,
        _token: token,
      }),
    })
      .then(response => response.json())
      .then(data => CheckResponse(data))
      .catch(err => setCatchError(err));
  };

  useEffect(() => {
    async function fetchMyApi() {
      let response = await fetch(`/api/admin/changelog/data/${id}`);
      response = await response.json();
      setDefault(response);
      setLoading(false);
    }

    if (id !== undefined) {
      setEditType('bearbeiten');
      fetchMyApi();
    } else {
      setLoading(false);
    }
  }, [id]);

  if (loading) {
    return <LoadingAlertBox />;
  }

  return (
    <div className="container">
      <div className="overview_headline">
        <ErrorBoundary>
          <SaveInfoError responseText={responseText} errorText={errorText} />
        </ErrorBoundary>
        <ErrorBoundary>
          <Row>
            <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
              <PageHeadline label={`Admin - Changelog ${getEditType}`} />
            </Col>
          </Row>
          <Row>
            <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
              <GridSimple>
                <div className="form-group">
                  <label className="form-label">Release:</label>
                  <div className="controls">
                    <ErrorBoundary>
                      <Input
                        defaultValue={getRelease}
                        name="release"
                        placeholder=""
                        className="form-control"
                        onChange={e => setRelease(e.target.value)}
                      />
                    </ErrorBoundary>
                  </div>
                </div>
              </GridSimple>
            </Col>
          </Row>
          <Row>
            <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
              <GridSimple>
                <div className="form-group">
                  <label className="form-label">Datum:</label>
                  <div className="controls">
                    <ErrorBoundary>
                      <Input
                        defaultValue={getDate}
                        name="datum"
                        placeholder=""
                        className="form-control"
                        onChange={e => setDate(e.target.value)}
                      />
                    </ErrorBoundary>
                  </div>
                </div>
              </GridSimple>
            </Col>
          </Row>
          <Row>
            <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
              <GridSimple>
                {getChangelog.map((changelog, index) => (
                  <div key={index}>
                    <Row>
                      <Col xxl={10} xl={10} lg={10} md={10} sm={10} xs={10}>
                        <div className="form-group">
                          <label className="form-label" />
                          <div className="controls">
                            <ErrorBoundary>
                              <Input
                                defaultValue={changelog}
                                name={`changelog[${index}]`}
                                placeholder=""
                                className="form-control"
                                onChange={e => onChangeValue(index, 'changelog', e)}
                              />
                            </ErrorBoundary>
                          </div>
                        </div>
                      </Col>
                      <Col xxl={2} xl={2} lg={2} md={2} sm={2} xs={2}>
                        <div className="form-group">
                          <label className="form-label" />
                          <div className="controls">
                            <button
                              type="button"
                              title="Entfernen"
                              onClick={() => handleIngredientRemove(index)}
                            >
                              <Trashicon />
                            </button>
                          </div>
                        </div>
                      </Col>
                    </Row>
                  </div>
                ))}
                <Row>
                  <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
                    <button title="Log hinzufügen" type="button" onClick={AddNewItem}>
                      <Addicon />
                    </button>
                  </Col>
                </Row>
              </GridSimple>
            </Col>
          </Row>
          <SaveLine SubmitForm={SubmitForm} backurl="/changelog/overview" />
        </ErrorBoundary>
      </div>
    </div>
  );
};
export default ChangeLogAddEditComponent;
